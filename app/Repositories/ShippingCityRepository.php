<?php

namespace App\Repositories;

use App\Models\ShippingCity;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ShippingCityRepositoryInterface;

class ShippingCityRepository implements ShippingCityRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {

            $shipping_cities = ShippingCity::orderBy('name_en', 'ASC')->get();

            return $this->success('Fetched Shipping Cities', $shipping_cities);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $shipping_city = ShippingCity::create($request->all());

            DB::commit();

            return $this->success('Shipping City has been created successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function update(Request $request, ShippingCity $shipping_city)
    {
        DB::beginTransaction();

        try {
            if($shipping_city)
            {
                $shipping_city->update($request->all());

                DB::commit();

                return $this->success('Shipping City has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function delete(ShippingCity $shipping_city)
    {
        try {

            if($shipping_city)
            {

                $shipping_city->delete();

                return $this->success('Shipping City has been deleted');
            }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    public function setStatus(Request $request, ShippingCity $shipping_city)
    {

        try {

           if($shipping_city)
           {

                $status = $request->query('status');

                $shipping_city->update(['is_active' => $status]);

                return $this->success('Shipping City Status has been changed');

           }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }
}
