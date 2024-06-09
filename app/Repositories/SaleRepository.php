<?php

namespace App\Repositories;

use DateTime;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Category;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SaleRepositoryInterface;
use App\Http\Resources\OrderProductResource;

class SaleRepository implements SaleRepositoryInterface
{
    use ApiResponses;

    public function index(Request $request)
    {
        try {

            $start_date_param = $request->query('start_date');
            $end_date_param = $request->query('end_date');

            $parsedStartDate = Carbon::createFromFormat('Y-m-d', $start_date_param);

            $parsedEndDate = Carbon::createFromFormat('Y-m-d', $end_date_param);

            $start_date = $parsedStartDate->format('Y-m-d');
            $end_date = $parsedEndDate->format('Y-m-d');

            $orders = Order::whereBetween('created_at', [$start_date, $end_date])->where('order_status', 'confirmed')->with('products')->get();

            $overall = $this->getOverAllSalesByDate($orders);

            $eachCategoryData = $this->getSalesDataWithCategoryByDate($orders);

            return [
                "overall" => $overall,
                "each_category_data" => $eachCategoryData
            ];

            return $this->success('Sales Data fetched successfully.', [
                "overall" => $overall,
                "each_category_data" => $eachCategoryData
            ]);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 500);

        }

    }

    public function getOverAllSalesByDate($orders)
    {
        $totalOrders = $orders->count();

        $totalSaveWithPoints = $orders->sum('save_with_points');

        $totalOrderAmount = $orders->sum('total_price') + $totalSaveWithPoints;

        $totalProductCount = $this->getOrderProductsCountByDate($orders);

        $totalDemand = $this->getTotalDemandByDate($orders);

        return [
            "total_orders" => $totalOrders,
            "total_order_amount" => $totalOrderAmount,
            "total_product_count" => $totalProductCount,
            "total_save_with_points" => $totalSaveWithPoints,
            "total_demand" => $totalDemand,
            "total_profit" => $totalOrderAmount - $totalDemand,
        ];
    }

    public function getSalesDataWithCategoryByDate($orders)
    {
        $categoriesData = collect();

        foreach ($orders as $order) {
            $order->load('products.category');

            $groupedProducts = $order->products->groupBy(function ($product) {
                return $product->category->name;
            });

            $groupedProducts->each(function ($products, $categoryName) use (&$categoriesData) {
                $totalAmount = $products->sum(function ($product) {
                    $perPrice = calculate_price_per_product($product->pivot->size->price, $product->pivot->quality->price);
                    return $perPrice * $product->pivot->qty;
                });

                $totalProductCount = $products->sum('pivot.qty');

                $totalDemand = $products->sum(function ($product) {
                    $perDemandPrice = calculate_source_price_per_product($product->pivot->size->source_price, $product->pivot->quality->source_price);
                    return $perDemandPrice * $product->pivot->qty;
                });

                $totalProfit = $totalAmount - $totalDemand;

                $categoriesData->push([
                    'category' => $categoryName,
                    'data' => [
                        'total_amount' => $totalAmount,
                        'total_product_count' => $totalProductCount,
                        'total_demand' => $totalDemand,
                        'total_profit' => $totalProfit
                    ]
                ]);
            });
        }

        return $categoriesData;
    }



    public function getOrderProductsCountByDate($orders)
    {
        $productCount = 0;

        foreach($orders as $order)
        {
            foreach($order->products as $product)
            {
                $productCount += $product->pivot->qty;
            }
        }

        return $productCount;
    }


    public function getTotalDemandByDate($orders)
    {
        $totalProfit = 0;
        $totalDemand = 0;

        foreach($orders as $order)
        {
            foreach($order->products as $product)
            {
                $salePrice = calculate_price_per_product($product->pivot->size->price, $product->pivot->quality->price);

                $demandPrice = calculate_source_price_per_product($product->pivot->size->source_price, $product->pivot->quality->source_price);

                $totalDemand += $demandPrice * $product->pivot->qty;
            }
        }

        return $totalDemand;
    }
}
