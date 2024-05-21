<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {

            $orders = Order::with('user')->latest()->get();

            return $this->success('Fetched Orders', $orders);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }

    public function orderProducts(Order $order)
    {
        try {
            $userProducts = $order->products->pluck('id')->toArray();

            $orderProducts = Product::with('category')
            ->whereIn('id', $userProducts)
            ->get()
            ->groupBy('category_id')
            ->map(function ($products, $categoryId) {
                $categoryName = $products->first()->category->name;
                return [
                    'category' => $categoryName,
                    'products' => $products
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

                DB::commit();

                return $this->success('Order has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {
            DB::rollback();

            return $this->error($e->getMessage());
        }
    }

}
