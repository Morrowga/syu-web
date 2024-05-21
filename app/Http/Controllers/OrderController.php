<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\OrderUpdateRequest;
use App\Interfaces\OrderRepositoryInterface;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->index();

        return Inertia::render('Order/Index', [
            "orders" => $orders['data']
        ]);
    }

    public function edit(Order $order)
    {
        $products = $this->orderRepository->orderProducts($order);

        // return $products['data'];

        return Inertia::render('Order/Edit',[
            "order_detail" => new OrderResource($order),
            "data" => $products['data']
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $updateOrder = $this->orderRepository->update($request,$order);

        Session::flash('message', $updateOrder['message']);

        return redirect()->route('orders.index');
    }

    public function destroy(Order $order)
    {
        $deleteOrder = $this->orderRepository->delete($order);

        return redirect()->route('orders.index');
    }

}
