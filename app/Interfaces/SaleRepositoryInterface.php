<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface SaleRepositoryInterface
{
    public function index(Request $request);
}
