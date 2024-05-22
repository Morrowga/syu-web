<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\WishlistResource;
use App\Interfaces\Api\WishlistRepositoryInterface;

class WishlistRepository implements WishlistRepositoryInterface
{
    use ApiResponses;

    public function index(Request $request)
    {
        try {

            $q = $request->query('q');

            $wishlistCategoryId = $request->query('category');

            $user = Auth::user();

            $loadWishlists = $user->load('wishlists');

            $wishlistIds = $loadWishlists->wishlists->pluck('id');

            if($wishlistCategoryId != null)
            {
                $wishlists = Product::whereIn('id', $wishlistIds)
                ->where('category_id', $wishlistCategoryId)
                ->where('is_active', 1)
                ->where('name', 'like', "%$q%")
                ->paginate(10);
            } else {
                $wishlists = Product::whereIn('id', $wishlistIds)
                ->where('is_active', 1)
                ->where('name', 'like', "%$q%")
                ->paginate(10);
            }


            $wishlistsArray = [
                'data' => WishlistResource::collection($wishlists),
                'total' => $wishlists->total(),
                'per_page' => $wishlists->perPage(),
                'current_page' => $wishlists->currentPage(),
                'last_page' => $wishlists->lastPage(),
                'from' => $wishlists->firstItem(),
                'to' => $wishlists->lastItem(),
            ];


            return $this->success('Wishlist fetched successfully.', $wishlistsArray);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $user = Auth::user();

            $productId = $request->product_id;

            $wishlist = Wishlist::create([
                "user_id" => $user->id,
                "product_id" => $productId
            ]);

            DB::commit();

            return $this->success('Wishlist created successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage(),500);

        }
    }

    public function destroy(Product $wishlist)
    {
        try {

            if($wishlist)
            {
                $user = Auth::user();

                $wishlistData = $user->wishlists()->detach($wishlist->id);

                return $this->success('Wishlist deleted successfully.');
            }

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

}
