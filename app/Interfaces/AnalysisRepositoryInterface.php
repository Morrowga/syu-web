<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AnalysisRepositoryInterface
{
    public function index(Request $request);
}
