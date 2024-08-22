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
            $orders = collect();

            if ($request->query('type') != 'lifetime' && $start_date_param && $end_date_param) {
                $parsedStartDate = Carbon::createFromFormat('Y-m-d', $start_date_param);
                $parsedEndDate = Carbon::createFromFormat('Y-m-d', $end_date_param);

                $start_date = $parsedStartDate->format('Y-m-d');
                $end_date = $parsedEndDate->format('Y-m-d');

                Order::whereBetween('created_at', [$start_date, $end_date])
                    ->where('order_status', 'confirmed')
                    ->with('products')
                    ->chunk(1000, function ($chunk) use (&$orders) {
                        $orders = $orders->merge($chunk);
                    });
            } else {
                Order::where('order_status', 'confirmed')
                ->with('products')
                ->chunk(1000, function ($chunk) use (&$orders) {
                    $orders = $orders->merge($chunk);
                });
            }

            $overall = $this->getOverAllSales($orders);
            $eachCategoryData = $this->getSalesDataWithCategory($orders);

            return $this->success('Sales Data fetched successfully.', [
                "overall" => $overall,
                "each_category_data" => $eachCategoryData
            ]);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function getOverAllSales($orders)
    {
        $totalOrders = $orders->count();

        $totalSaveWithPoints = $orders->sum('save_with_points');

        $totalOrderAmount = $orders->sum('total_price') + $totalSaveWithPoints;

        $totalProductCount = $this->getOrderProductsCount($orders);

        $totalDemand = $this->getTotalDemand($orders);

        return [
            "total_orders" => $totalOrders,
            "total_order_amount" => $totalOrderAmount,
            "total_product_count" => $totalProductCount,
            "total_save_with_points" => $totalSaveWithPoints,
            "total_demand" => $totalDemand,
            "total_profit" => $totalOrderAmount - $totalDemand,
        ];
    }

    public function getSalesDataWithCategory($orders)
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

                // Check if the category already exists in the collection
                $categoryData = $categoriesData->firstWhere('category', $categoryName);

                if ($categoryData) {
                    // Update the existing category data
                    $categoryData['data']['total_amount'] += $totalAmount;
                    $categoryData['data']['total_product_count'] += $totalProductCount;
                    $categoryData['data']['total_demand'] += $totalDemand;
                    $categoryData['data']['total_profit'] += $totalProfit;

                    // Update the collection with the modified data
                    $categoriesData = $categoriesData->map(function ($item) use ($categoryData) {
                        return $item['category'] === $categoryData['category'] ? $categoryData : $item;
                    });
                } else {
                    // Add a new entry for the category
                    $categoriesData->push([
                        'category' => $categoryName,
                        'data' => [
                            'total_amount' => $totalAmount,
                            'total_product_count' => $totalProductCount,
                            'total_demand' => $totalDemand,
                            'total_profit' => $totalProfit
                        ]
                    ]);
                }
            });
        }

        return $categoriesData;
    }



    public function getOrderProductsCount($orders)
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


    public function getTotalDemand($orders)
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
