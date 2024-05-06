<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\WishlistResource;
use App\Interfaces\Api\WishlistRepositoryInterface;

class WishlistRepository implements WishlistRepositoryInterface
{
    use ApiResponses;

    public function createWishlist(Request $request)
    {
        try {

            $user = Auth::user();

            // $productIdsArray = json_decode($request->products, true);
            $productIdsArray = $request->products;

            $wishlists = [];

            foreach($productIdsArray as $productId)
            {
                $syncData[] = ['user_id' => $user->id, 'product_id' => $productId];
            }

            DB::table('wishlists')->insert($syncData);

            $wishlistData = $user->load('wishlists');

            return $this->success('Wishlist created successfully.', $wishlistData->wishlists);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

}
