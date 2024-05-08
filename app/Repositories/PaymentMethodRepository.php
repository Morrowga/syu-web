<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\PaymentMethodRepositoryInterface;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {

            $paymentMethods = PaymentMethod::orderBy('created_at', 'DESC')->get();

            return $this->success('Fetched Payment Methods', $paymentMethods);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $paymentMethod = PaymentMethod::create($request->all());

            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $paymentMethod->addMediaFromRequest('image')->toMediaCollection('images', 'payment_methods');
            }

            DB::commit();

            return $this->success('Payment Method has been created successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        DB::beginTransaction();

        try {
            if($paymentMethod)
            {
                $paymentMethod->update($request->all());

                if (request()->hasFile('image') && request()->file('image')->isValid()) {
                    $paymentMethod->clearMediaCollection('images');

                    $paymentMethod->addMediaFromRequest('image')->toMediaCollection('images', 'payment_methods');
                }

                DB::commit();

                return $this->success('Payment Method has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function delete(PaymentMethod $paymentMethod)
    {
        try {

            if($paymentMethod)
            {
                $paymentMethod->clearMediaCollection('images');

                $paymentMethod->delete();

                return $this->success('Payment Method has been deleted');
            }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    public function setStatus(Request $request, PaymentMethod $paymentMethod)
    {

        try {

           if($paymentMethod)
           {

                $status = $request->query('status');

                $paymentMethod->update(['is_active' => $status]);

                return $this->success('Payment Method Status has been changed');

           }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }
}
