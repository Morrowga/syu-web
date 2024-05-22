<?php

namespace App\Interfaces\Api;

use App\Models\Order;
use Illuminate\Http\Request;

interface OrderProcessRepositoryInterface
{
    public function index();

    public function show(Order $order);

    public function showProductDetail(Request $request, Order $order);

    public function store(Request $request);

    public function paid(Request $request, Order $order);

    public function paymentMethods();
}
