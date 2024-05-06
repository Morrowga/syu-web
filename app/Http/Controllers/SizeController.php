<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\SizeCreateRequest;
use App\Http\Requests\SizeUpdateRequest;
use App\Interfaces\SizeRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;

class SizeController extends Controller
{
    private SizeRepositoryInterface $sizeRepository;
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(SizeRepositoryInterface $sizeRepository,CategoryRepositoryInterface $categoryRepository)
    {
        $this->sizeRepository = $sizeRepository;
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
            return redirect()->route('size-home');
        }

        $sizes = $this->sizeRepository->index();

        $category = $this->categoryRepository->findCategory($categoryId);

        return Inertia::render('SizeHome/Size/Index', [
            "sizes" => $sizes['data'],
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
            return redirect()->route('size-home');
        }

        $category = $this->categoryRepository->findCategory($categoryId);

        return Inertia::render('SizeHome/Size/Create', [
            "category" => $category['data']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeCreateRequest $request)
    {
        $createSize = $this->sizeRepository->store($request);

        Session::flash('message', $createSize['message']);

        return redirect()->route('sizes.index', ['category' => $request->category_id]);
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
    public function edit(Size $size)
    {
        return Inertia::render('SizeHome/Size/Edit',[
            "size" => $size->load('category')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeUpdateRequest $request, Size $size)
    {
        $updateSize = $this->sizeRepository->update($request,$size);

        Session::flash('message', $updateSize['message']);

        return redirect()->route('sizes.index', ['category' => $size->category_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $deleteSize = $this->sizeRepository->delete($size);

        return redirect()->route('sizes.index', ['category' => $size->category_id]);
    }

    public function setStatus(Request $request, Size $size)
    {
        $setStatusSize = $this->sizeRepository->setStatus($request, $size);

        return redirect()->route('sizes.index', ['category' => $size->category_id]);
    }


    public function setDefault(Request $request, Size $size)
    {
        $setDefaultSize = $this->sizeRepository->setDefault($request, $size);

        return redirect()->route('sizes.index', ['category' => $size->category_id]);
    }
}
