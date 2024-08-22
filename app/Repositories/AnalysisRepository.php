<?php

namespace App\Repositories;

use DateTime;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Category;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\AnalysisRepository;
use App\Http\Resources\OrderProductResource;
use App\Interfaces\AnalysisRepositoryInterface;

class AnalysisRepository implements AnalysisRepositoryInterface
{
    use ApiResponses;

    public function index(Request $request)
    {
        try {
            $orders = collect();

            if ($request->query('type') != 'lifetime') {
                $start_date_param = $request->query('start_date');
                $end_date_param = $request->query('end_date');

                $parsedStartDate = Carbon::createFromFormat('Y-m-d', $start_date_param);
                $parsedEndDate = Carbon::createFromFormat('Y-m-d', $end_date_param);

                $start_date = $parsedStartDate->format('Y-m-d');
                $end_date = $parsedEndDate->format('Y-m-d');

                Order::whereBetween('created_at', [$start_date, $end_date])
                    ->with('user.shippingcity', 'products.category', 'transaction')
                    ->chunk(1000, function ($chunk) use (&$orders) {
                        $orders = $orders->merge($chunk);
                    });
            } else {

                Order::with('user.shippingcity', 'products.category', 'transaction')
                ->chunk(1000, function ($chunk) use (&$orders) {
                    $orders = $orders->merge($chunk);
                });

            }

            $age = $this->getUserAndOrderCountsByAge($orders->where('order_status', 'confirmed'));
            $gender = $this->getUserAndOrderCountsByGender($orders->where('order_status', 'confirmed'));
            $bestSellingCategory = $this->getBestSellingProductCategory($orders->where('order_status', 'confirmed'));
            $bestSellingCity = $this->getBestSellingCity($orders->where('order_status', 'confirmed'));

            $totalcancelOrders = $orders->where('order_status', 'cancel')->count();
            $totalcodOrders = $orders->where('payment_type', 'cod')->count();
            $totalPrepaidOrders = $orders->where('payment_type', 'pp')->count();

            $paymentMethods = $this->getPaymentMethodCounts($orders->where('payment_type', 'pp')->where('order_status', 'confirmed'));

            $data = [
                "age" => $age,
                "gender" => $gender,
                "best_selling_category" => $bestSellingCategory,
                "best_selling_city" => $bestSellingCity,
                "totalcancelOrders" => $totalcancelOrders,
                "totalcod" => $totalcodOrders,
                "totalpp" => $totalPrepaidOrders,
                "payment_methods" => $paymentMethods,
            ];

            return $this->success('Analysis Data fetched successfully.', $data);


        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function getUserAndOrderCountsByGender($orders)
    {
        $possibleGenders = ['male', 'female', 'other'];

        $genderCounts = $this->analyzeOrdersByAttribute($orders, function($user) {
            return $user->gender;
        }, $possibleGenders);

        return $genderCounts;
    }

    public function getUserAndOrderCountsByAge($orders)
    {
        $possibleAges = ['above18', 'under18'];

        $ageCounts = $this->analyzeOrdersByAttribute($orders, function($user) {
            return $user->is_above_eighteen ? 'above18' : 'under18';
        }, $possibleAges);

        return $ageCounts;
    }

    function analyzeOrdersByAttribute(
        Collection $orders,
        callable $getAttribute,
        array $possibleAttributes
    ) {
        $counts = array_fill_keys($possibleAttributes, [
            'totaluser' => 0,
            'totalorders' => 0,
        ]);

        $uniqueUsers = array_fill_keys($possibleAttributes, collect());

        foreach ($orders as $order) {
            $user = $order->user;
            $attributeValue = $getAttribute($user);

            if (!isset($counts[$attributeValue])) {
                continue;
            }

            $counts[$attributeValue]['totalorders']++;
            if (!$uniqueUsers[$attributeValue]->contains($user->id)) {
                $uniqueUsers[$attributeValue]->push($user->id);
                $counts[$attributeValue]['totaluser']++;
            }
        }

        return $counts;
    }

    public function getBestSellingProductCategory($orders)
    {
        $categorySales = [];
        $bestSellingCategory = null;

        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                $category = $product->category;
                $quantity = $product->pivot->qty;

                if (!isset($categorySales[$category->name])) {
                    $categorySales[$category->name] = 0;
                }

                $categorySales[$category->name] += $quantity;
            }
        }

        if(count($categorySales) > 0)
        {
            $bestSellingCategory = array_keys($categorySales, max($categorySales))[0];
        }

        return $bestSellingCategory;
    }

    public function getBestSellingCity($orders)
    {
        $cityOrderCounts = [];

        foreach ($orders as $order) {
            if (!$order->user || !$order->user->shippingcity) {
                continue;
            }

            $city = $order->user->shippingcity;
            $cityName = $city->name_en;

            if (!isset($cityOrderCounts[$cityName])) {
                $cityOrderCounts[$cityName] = 0;
            }

            $cityOrderCounts[$cityName]++;
        }

        if (empty($cityOrderCounts)) {
            return [
                'best_selling_city' => null,
                'total_orders' => 0,
            ];
        }

        $bestSellingCityName = array_keys($cityOrderCounts, max($cityOrderCounts))[0];

        $totalOrders = $cityOrderCounts[$bestSellingCityName];

        return [
            'name' => $bestSellingCityName,
            'total_orders' => $totalOrders,
        ];
    }

    /**
     * Get the total count of each payment method.
     *
     * @param \Illuminate\Support\Collection $orders
     * @return array
     */
    private function getPaymentMethodCounts($orders)
    {
        $allPaymentMethods = PaymentMethod::pluck('name')->toArray();

        $paymentMethodCounts = array_fill_keys($allPaymentMethods, 0);

        foreach ($orders as $order) {
            $paymentMethod = $order->transaction ? $order->transaction->payment_method : '';

            if (isset($paymentMethodCounts[$paymentMethod])) {
                $paymentMethodCounts[$paymentMethod]++;
            }
        }

        $formattedCounts = [];
        foreach ($paymentMethodCounts as $method => $count) {
            $formattedCounts[] = [
                'method' => $method,
                'count' => $count
            ];
        }

        return $formattedCounts;
    }
}
