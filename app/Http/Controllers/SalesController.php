<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Interfaces\SaleRepositoryInterface;

class SalesController extends Controller
{
    private SaleRepositoryInterface $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function index()
    {
        return Inertia::render('Sales/Index');
    }

    public function getSalesData(Request $request)
    {
        $sales = $this->saleRepository->index($request);

        return $sales;
    }
}
