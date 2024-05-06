<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Models\Product;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Interfaces\Api\FeedsRepositoryInterface;

class FeedsRepository implements FeedsRepositoryInterface
{
    use ApiResponses;

    public function getFeeds(Request $request)
    {
        try {

            $q = $request->query('q');

            $productCategoryId = $request->query('category');

            $products = Product::where('category_id', $productCategoryId)
                                ->where('name', 'like', "%$q%")
                                ->paginate(20);

            $productsArray = [
                'data' => ProductResource::collection($products)->toArray($request),
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

}
