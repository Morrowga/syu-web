<?php

namespace App\Repositories\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Jobs\OrderExpiration;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Notifications\InAppNotification;
use App\Http\Resources\OrderProductResource;
use App\Http\Resources\PaymentMethodResource;
use App\Interfaces\Api\OrderProcessRepositoryInterface;

class OrderProcessRepository implements OrderProcessRepositoryInterface
{
    use ApiResponses;

    public function index()
    {
        try {

            $user = Auth::user();

            dispatch(new OrderExpiration($user->id));

            $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->with('products', 'transaction')->paginate(10);

            $ordersArray = [
                'data' => OrderResource::collection($orders),
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
            ];

            return $this->success('Order fetched successfully.', $orders);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

    public function checkOrders()
    {
        try {

            $user = Auth::user();

            dispatch(new OrderExpiration($user->id));

            return $this->success('Checking Order successfully.');

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

    public function cancelOrder(Order $order)
    {
        try {

            $order->order_status = 'cancel';
            $order->save();

            return $this->success('Order is now cancled.');

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

    public function show(Order $order)
    {
        if(!empty($order))
        {
            // return $order;

            return $this->success('Order fetched successfully.', new OrderResource($order));
        }

        return $this->error('Order Not Found.',500);
    }

    public function showProductDetail(Request $request, Order $order)
    {
        if(!empty($order))
        {
            $products = $order->products()->where('category_id', $request->query('category_id'))->get();

            return $this->success('Order Products fetched successfully.', OrderProductResource::collection($products));
        }

        return $this->error('Order Not Found.',500);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $setting = Setting::first();

            $user = Auth::user();

            $products = json_decode($request->products, true);

            $waiting_days = 0;

            if(count($products) > 0)
            {
               $waiting_days = $this->findEndDate($products);
            }

            $order = Order::create([
                "order_no" => $this->generateOrderNumber(),
                "waiting_start_date" => Carbon::now(),
                "waiting_end_date" => Carbon::now()->addDays($waiting_days),
                "order_expired_date" => Carbon::now()->addDays($setting->expire_day),
                "order_status" =>  $request->payment_type == 'cod' ? 'confirmed' : 'pending',
                "total_price" => $request->total_price,
                "save_with_points" => $request->used_points,
                "payment_type" => $request->payment_type,
                "user_id" => $user->id,
                "note" => $request->note,
            ]);

            if(count($products) > 0)
            {
                foreach($products as $product)
                {
                    $order->products()->attach([
                        $product['product_id'] => ['size_id' => $product['size_id'], 'quality_id' => $product['quality_id'], 'qty' => $product['qty']],
                    ]);
                }
            }

            if($request->used_points > 0) {
                $user->points -= $request->used_points;
                $user->save();
            }

            $notification = [
                'title' => 'Orders',
                'message' => 'Your order ( ' . $order->order_no . ' )  has been placed.',
                'type' => 'order',
                'screen_id' => $order->id,
            ];

            $user->notify(new InAppNotification($notification));

            DB::commit();

            return $this->success('Order created successfully.', new OrderResource($order));

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage(),500);

        }
    }

    public function paid(Request $request,Order $order)
    {
        DB::beginTransaction();

        try {
            if($order->order_status == 'pending')
            {
                    $user = Auth::user();

                    if ($user->shippingcity !== null) {
                        $order->update([
                            "paid_delivery_cost" => $request->paid_delivery_cost == true ? 1 : 0,
                            "order_status" => 'confirmed',
                        ]);

                        $transaction = Transaction::create($request->merge(['order_id' => $order->id])->all());

                        $notification = [
                            'title' => 'Orders',
                            'message' => 'Your order ( ' . $order->order_no . ' )  is in reviewing progress.',
                            'type' => 'order',
                            'screen_id' => $order->id,
                        ];

                        $user->notify(new InAppNotification($notification));


                        DB::commit();

                        return $this->success('Payment created successfully.');
                    }

                    return $this->error('Shipping Address does not exist in current user.', 400);

            } else if($order->order_status == 'confirmed') {

                return $this->error('Order is already paid.', 400);

            } else {

                return $this->error('Order cannot paid.', 400);

            }

        } catch (\Exception $e) {

            $order->clearMediaCollection('images');

            DB::rollback();

            return $this->error($e->getMessage(), 500);

        }
    }

    public function paymentMethods()
    {
        try {
            $paymentMethods = PaymentMethod::get();

            return $this->success('Payment methods fetched successfully.', PaymentMethodResource::collection($paymentMethods));

        } catch (\Exception $e) {
        }
    }


    function generateOrderNumber($length = 5)
    {

        $randomNumbers = '';

        for ($i = 0; $i < 5; $i++) {
            $randomNumbers .= rand(0, 9);
        }

        $randomLetter = Str::random(1, 'abcdefghijklmnopqrstuvwxyz');

        $randomString = $randomNumbers . $randomLetter;

        $orderNumber = '#Order' . $randomString;

        return $orderNumber;
    }

    function findEndDate($products)
    {
        $categoryCounts = [];

        foreach($products as $product)
        {
            $category_id = $product['category_id'];

            if (isset($categoryCounts[$category_id])) {
                $categoryCounts[$category_id]++;
            } else {
                $categoryCounts[$category_id] = 1;
            }
        }

        $maxCount = max($categoryCounts);
        $maxCategoryIds = array_keys($categoryCounts, $maxCount);

        $maxCategoryId = $maxCategoryIds[0];

        $find_category = Category::find($maxCategoryId);

        if(!$find_category)
        {
            return 0;
        }

        return $find_category->waiting_days;
    }
}
