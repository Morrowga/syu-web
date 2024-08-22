<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Interfaces\AnalysisRepositoryInterface;

class AnalysisController extends Controller
{
    private AnalysisRepositoryInterface $analysisRepository;

    public function __construct(AnalysisRepositoryInterface $analysisRepository)
    {
        $this->analysisRepository = $analysisRepository;
    }

    public function index()
    {
        return Inertia::render('Analysis/Index');
    }

    public function getAnalysisData(Request $request)
    {
        $analysis = $this->analysisRepository->index($request);

        return $analysis;
    }
}
