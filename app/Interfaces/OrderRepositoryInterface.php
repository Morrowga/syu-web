<?php

namespace App\Interfaces;

use App\Models\Order;
use Illuminate\Http\Request;

interface OrderRepositoryInterface
{
    public function index();

    public function orderProducts(Order $order);

    public function update(Request $request, Order $order);

    public function delete(Order $order);
}
