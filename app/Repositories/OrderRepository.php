<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Jobs\OrderExpiration;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Notifications\InAppNotification;
use App\Http\Resources\OrderProductResource;
use App\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {

            dispatch(new OrderExpiration());

            $orders = Order::with('user', 'products', 'transaction')->latest()->get();

            return $this->success('Fetched Orders', $orders);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }

    public function orderProducts(Order $order)
    {
        try {
            $userProducts = $order->products;

            $orderProducts = $userProducts->load('category')
            ->groupBy('category_id')
            ->map(function ($products, $categoryId) {
                $categoryName = $products->first()->category->name;
                return [
                    'category' => $categoryName,
                    'products' => OrderProductResource::collection($products)
                ];
            })
            ->values()
            ->toArray();

            return $this->success('Fetched Order Products', $orderProducts);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }

    public function update(Request $request, Order $order)
    {
        DB::beginTransaction();

        try {
            if($order)
            {
                $order->update($request->all());

                $notification = [
                    'title' => 'Orders',
                    'message' => 'Your order ( ' . $order->order_no . ' ) is now ' . ($order->order_status == 'confirmed' ? 'approved' : ($order->order_status == 'cancel' ? 'canceled' : $order->order_status)) . '.',
                    'type' => 'order',
                    'screen_id' => $order->id,
                ];

                $user = $order->user;

                $user->notify(new InAppNotification($notification));

                DB::commit();

                return $this->success('Order has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {
            DB::rollback();

            return $this->error($e->getMessage());
        }
    }

    public function delete(Order $order)
    {
        try {
            if($order)
            {
                $order->delete();
            }

            return $this->success('Order has been deleted');

        } catch (\Exception $e) {

            return $this->error($e->getMessage());
        }
    }
}
