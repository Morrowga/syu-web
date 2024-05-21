<?php

namespace App\Repositories\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentMethodResource;
use App\Interfaces\Api\OrderProcessRepositoryInterface;

class OrderProcessRepository implements OrderProcessRepositoryInterface
{
    use ApiResponses;

    public function index()
    {
        try {

            $user = Auth::user();


            $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->with('products')->paginate(10);

            $ordersArray = [
                'data' => OrderResource::collection($orders),
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
            ];

            return $this->success('Order fetched successfully.', $ordersArray);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

    public function show(Order $order)
    {
        if(!empty($order))
        {
            return $this->success('Order fetched successfully.', new OrderResource($order));
        }

        return $this->error('Order Not Found.',500);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $setting = Setting::first();

            $currentDate = Carbon::now();

            $user = Auth::user();

            $order = Order::create([
                "order_no" => $this->generateOrderNumber(),
                "waiting_start_date" => $currentDate->toDateString(),
                "waiting_end_date" => $currentDate->addDays($request->waiting_days)->toDateString(),
                "order_expired_date" => $currentDate->addDays($setting->expire_day),
                "order_status" => 'pending',
                "total_price" => $request->total_price,
                "overall_price" => $request->total_price,
                "user_id" => $user->id,
                "note" => $request->note,
            ]);

            $products = json_decode($request->products, true);

            foreach($products as $product)
            {
                $order->products()->attach([
                    $product['product_id'] => ['size_id' => $product['size_id'], 'quality_id' => $product['quality_id'], 'qty' => $product['qty']],
                ]);
            }

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
            if($order->is_paid == 0)
            {
                if (request()->hasFile('image') && request()->file('image')->isValid()) {

                    $order->addMediaFromRequest('image')->toMediaCollection('images', 'payment');

                    $user = Auth::user();

                    if ($user->shippingcity !== null) {
                        $order->update([
                            "overall_price" => $request->paid_delivery_cost == true ? $order->total_price + $user->shippingcity->cost : $order->total_price,
                            "payment_method" => $request->payment_method,
                            "paid_delivery_cost" => $request->paid_delivery_cost == true ? 1 : 0,
                            "is_paid" => 1,
                        ]);

                        DB::commit();

                        return $this->success('Payment created successfully.');
                    }

                    return $this->error('Shipping Address does not exist in current user.', 400);
                }

                return $this->error('Payment Screenshot is invalid.', 400);
            }

            return $this->error('Order is already paid.', 400);

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
}
