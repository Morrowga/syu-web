<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentCreateRequest;
use App\Http\Requests\OrderProcessCreateRequest;
use App\Interfaces\Api\OrderProcessRepositoryInterface;

class OrderProcessController extends Controller
{
    private OrderProcessRepositoryInterface $orderProcessRepository;

    public function __construct(OrderProcessRepositoryInterface $orderProcessRepository)
    {
        $this->orderProcessRepository = $orderProcessRepository;
    }

    public function index()
    {
        return $this->orderProcessRepository->index();
    }

    public function checkOrders()
    {
        return $this->orderProcessRepository->checkOrders();
    }

    public function cancelOrder(Order $order)
    {
        return $this->orderProcessRepository->cancelOrder($order);
    }

    public function show(Order $order)
    {
        return $this->orderProcessRepository->show($order);
    }

    public function showProductDetail(Request $request, Order $order)
    {
        return $this->orderProcessRepository->showProductDetail($request, $order);
    }

    public function store(OrderProcessCreateRequest $request)
    {
        return $this->orderProcessRepository->store($request);
    }

    public function paid(PaymentCreateRequest $request,Order $order)
    {
        return $this->orderProcessRepository->paid($request, $order);
    }

    public function paymentMethods()
    {
        return $this->orderProcessRepository->paymentMethods();
    }
}
