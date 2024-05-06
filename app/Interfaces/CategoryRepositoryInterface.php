<?php

namespace App\Interfaces;

use App\Models\Category;
use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function index();

    public function store(Request $request);

    public function update(Request $request, Category $category);

    public function delete(Category $category);

    public function setStatus(Request $request, Category $category);

    public function findCategory(string $categoryId);
}
