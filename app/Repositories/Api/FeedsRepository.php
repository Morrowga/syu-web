<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Interfaces\Api\FeedsRepositoryInterface;

class FeedsRepository implements FeedsRepositoryInterface
{
    use ApiResponses;

    public function getProducts(Request $request)
    {
        try {

            $q = $request->query('q');

            $productCategoryId = $request->query('category');

            $products = Product::where('category_id', $productCategoryId)
                                ->where('name', 'like', "%$q%")
                                ->paginate(20);

            $productsArray = [
                'data' => ProductResource::collection($products),
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ];

            return $this->success('Feeds fetched successfully.', $productsArray);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    public function getCategories()
    {
        try {

            $categories = Category::with(['sizes', 'qualities'])->paginate(10);

            $categoriesArray = [
                'data' => CategoryResource::collection($categories),
                'total' => $categories->total(),
                'per_page' => $categories->perPage(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem(),
            ];

            return $this->success('Categories fetched successfully.', $categories);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }
}
