<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\SizeCreateRequest;
use App\Http\Requests\SizeUpdateRequest;
use App\Interfaces\CategoryRepositoryInterface;

class SizeHomeController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->index();

        return Inertia::render('SizeHome/Index',[
            "categories" => $categories['data']
        ]);
    }
}
