<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface FeedsRepositoryInterface
{
    public function getProducts(Request $request);

    public function getCategories();
}
