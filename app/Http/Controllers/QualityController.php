<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Quality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\QualityCreateRequest;
use App\Http\Requests\QualityUpdateRequest;
use App\Interfaces\QualityRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;

class QualityController extends Controller
{
    private QualityRepositoryInterface $qualityRepository;
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(QualityRepositoryInterface $qualityRepository,CategoryRepositoryInterface $categoryRepository)
    {
        $this->qualityRepository = $qualityRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryId = $request->query('category');

        if(!$categoryId)
        {
            return redirect()->route('quality-home');
        }

        $qualities = $this->qualityRepository->index();
        $category = $this->categoryRepository->findCategory($categoryId);

        return Inertia::render('QualityHome/Quality/Index', [
            "qualities" => $qualities['data'],
            "category" => $category['data']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categoryId = $request->query('category');

        if(!$categoryId)
        {
            return redirect()->route('quality-home');
        }

        $category = $this->categoryRepository->findCategory($categoryId);

        return Inertia::render('QualityHome/Quality/Create', [
            "category" => $category['data']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QualityCreateRequest $request)
    {
        $createQuality = $this->qualityRepository->store($request);

        Session::flash('message', $createQuality['message']);

        return redirect()->route('qualities.index', ['category' => $request->category_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quality $quality)
    {
        return Inertia::render('QualityHome/Quality/Edit',[
            "quality" => $quality->load('category')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QualityUpdateRequest $request, Quality $quality)
    {
        $updateQuality = $this->qualityRepository->update($request,$quality);

        Session::flash('message', $updateQuality['message']);

        return redirect()->route('qualities.index', ['category' => $quality->category_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quality $quality)
    {
        $deleteQuality = $this->qualityRepository->delete($quality);

        return redirect()->route('qualities.index', ['category' => $quality->category_id]);
    }

    public function setStatus(Request $request, Quality $quality)
    {
        $setStatusQuality = $this->qualityRepository->setStatus($request, $quality);

        return redirect()->route('qualities.index', ['category' => $quality->category_id]);
    }

    public function setDefault(Request $request, Quality $quality)
    {
        $setDefaultSize = $this->qualityRepository->setDefault($request, $quality);

        return redirect()->route('qualities.index', ['category' => $quality->category_id]);
    }
}
