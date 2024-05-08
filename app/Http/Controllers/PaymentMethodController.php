<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\PaymentMethodCreateRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;
use App\Interfaces\PaymentMethodRepositoryInterface;

class PaymentMethodController extends Controller
{
    private PaymentMethodRepositoryInterface $paymentMethodRespository;

    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRespository)
    {
        $this->paymentMethodRespository = $paymentMethodRespository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = $this->paymentMethodRespository->index();

        return Inertia::render('PaymentMethod/Index', [
            "payment_methods" => $paymentMethods['data']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('PaymentMethod/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodCreateRequest $request)
    {
        $createPaymentMethod = $this->paymentMethodRespository->store($request);

        Session::flash('message', $createPaymentMethod['message']);

        return redirect()->route('payment-methods.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return Inertia::render('PaymentMethod/Edit',[
            "payment_method" => $paymentMethod
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentMethodUpdateRequest $request, PaymentMethod $paymentMethod)
    {
        $updatePaymentMethod = $this->paymentMethodRespository->update($request,$paymentMethod);

        Session::flash('message', $updatePaymentMethod['message']);

        return redirect()->route('payment-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $deletePaymentMethod = $this->paymentMethodRespository->delete($paymentMethod);

        return redirect()->route('payment-methods.index');
    }

    public function setStatus(Request $request, PaymentMethod $paymentMethod)
    {
        $setStatusPaymentMethod = $this->paymentMethodRespository->setStatus($request, $paymentMethod);

        return redirect()->route('payment-methods.index');
    }
}
