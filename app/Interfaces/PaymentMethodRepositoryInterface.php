<?php

namespace App\Interfaces;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

interface PaymentMethodRepositoryInterface
{
    public function index();

    public function store(Request $request);

    public function update(Request $request, PaymentMethod $paymentMethod);

    public function delete(PaymentMethod $paymentMethod);

    public function setStatus(Request $request, PaymentMethod $paymentMethod);
}
