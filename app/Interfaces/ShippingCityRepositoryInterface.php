<?php

namespace App\Interfaces;

use App\Models\ShippingCity;
use Illuminate\Http\Request;

interface ShippingCityRepositoryInterface
{
    public function index();

    public function store(Request $request);

    public function update(Request $request, ShippingCity $shipping_city);

    public function delete(ShippingCity $shipping_city);

    public function setStatus(Request $request, ShippingCity $shipping_city);
}
