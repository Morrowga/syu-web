<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Api\WishlistRepositoryInterface;

class WishlistRepository implements WishlistRepositoryInterface
{
    use ApiResponses;

    public function createWishlist(Request $request)
    {
        try {

            // return $this->success('Feeds fetched successfully.', $productsArray);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

}
