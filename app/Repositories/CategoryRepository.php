<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {

            $categories = Category::get();

            return $this->success('Fetched Categories', $categories);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $category = Category::create($request->all());

            DB::commit();

            return $this->success('Category has been created successfully.');

        } catch (\Exception $e) {
            DB::rollback();

            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, Category $category)
    {
        DB::beginTransaction();

        try {
            if($category)
            {
                $category->update($request->all());

                DB::commit();

                return $this->success('Category has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {
            DB::rollback();

            return $this->error($e->getMessage());
        }
    }

    public function delete(Category $category)
    {
        try {
            if($category)
            {
                $category->delete();
            }

            return $this->success('Category has been deleted');

        } catch (\Exception $e) {

            return $this->error($e->getMessage());
        }
    }

    public function setStatus(Request $request, Category $category)
    {

        try {

            if($category)
            {
                $status = $request->query('status');

                $category->update(['is_active' => $status]);

                return $this->success('Category Status has been changed.');
            }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }

    public function findCategory(string $categoryId)
    {
        try {
            $category = Category::find($categoryId);

            return $this->success('Category Found.', $category);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }
}
