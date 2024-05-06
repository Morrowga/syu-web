<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface WishlistRepositoryInterface
{
    public function createWishlist(Request $request);
}
