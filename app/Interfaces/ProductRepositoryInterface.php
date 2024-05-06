<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function index();

    public function store(Request $request);

    public function update(Request $request, Product $product);

    public function delete(Product $product);

    public function setStatus(Request $request, Product $product);
}
