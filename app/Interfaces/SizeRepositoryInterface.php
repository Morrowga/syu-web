<?php

namespace App\Interfaces;

use App\Models\Size;
use Illuminate\Http\Request;

interface SizeRepositoryInterface
{
    public function index();

    public function store(Request $request);

    public function update(Request $request, Size $size);

    public function delete(Size $size);

    public function setStatus(Request $request, Size $size);
}
