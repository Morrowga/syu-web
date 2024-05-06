<?php

namespace App\Interfaces;

use App\Models\Quality;
use Illuminate\Http\Request;

interface QualityRepositoryInterface
{
    public function index();

    public function store(Request $request);

    public function update(Request $request, Quality $quality);

    public function delete(Quality $quality);

    public function setStatus(Request $request, Quality $quality);
}
