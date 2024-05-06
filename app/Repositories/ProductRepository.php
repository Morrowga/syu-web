<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Category;

class ProductRepository implements ProductRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {

            $products = Product::where('category_id', request()->query('category'))->with('category')->orderBy('created_at', 'DESC')->get();

            return $this->success('Fetched Products', $products);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $product = Product::create($request->all());

            $product->load('category');

            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $product->addMediaFromRequest('image')->toMediaCollection('images', $product->category->name);
            }

            DB::commit();

            return $this->success('Product has been created successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();

        try {
            if($product)
            {
                $category = $request->query('category');

                $product->update($request->all());

                $product->load('category');

                if (request()->hasFile('image') && request()->file('image')->isValid()) {
                    $product->clearMediaCollection('images');

                    $product->addMediaFromRequest('image')->toMediaCollection('images', $product->category->name);
                }

                DB::commit();

                return $this->success('Category has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function delete(Product $product)
    {
        try {

            if($product)
            {
                $product->clearMediaCollection('images');

                $product->delete();

                return $this->success('Product has been deleted');
            }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    public function setStatus(Request $request, Product $product)
    {

        try {

           if($product)
           {

                $status = $request->query('status');

                $product->update(['is_active' => $status]);

                return $this->success('Product Status has been changed');

           }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }
}
