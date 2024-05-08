<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ShippingCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ShippingCityCreateRequest;
use App\Http\Requests\ShippingCityUpdateRequest;
use App\Interfaces\ShippingCityRepositoryInterface;

class ShippingCityController extends Controller
{
    private ShippingCityRepositoryInterface $shippingCityRepository;

    public function __construct(ShippingCityRepositoryInterface $shippingCityRepository)
    {
        $this->shippingCityRepository = $shippingCityRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shipping_cities = $this->shippingCityRepository->index();

        return Inertia::render('ShippingCity/Index', [
            "shipping_cities" => $shipping_cities['data'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('ShippingCity/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingCityCreateRequest $request)
    {
        $createShippingCity = $this->shippingCityRepository->store($request);

        Session::flash('message', $createShippingCity['message']);

        return redirect()->route('shipping-cities.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingCity $shipping_city)
    {
        return Inertia::render('ShippingCity/Edit',[
            "shipping_city" => $shipping_city
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingCityUpdateRequest $request, ShippingCity $shipping_city)
    {
        $updateShippingCity = $this->shippingCityRepository->update($request,$shipping_city);

        Session::flash('message', $updateShippingCity['message']);

        return redirect()->route('shipping-cities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCity $shipping_city)
    {
        $deleteShippingCity = $this->shippingCityRepository->delete($shipping_city);

        return redirect()->route('shipping-cities.index');
    }

    public function setStatus(Request $request, ShippingCity $shipping_city)
    {
        $setStatusShippingCity = $this->shippingCityRepository->setStatus($request, $shipping_city);

        return redirect()->route('shipping-cities.index');
    }
}
