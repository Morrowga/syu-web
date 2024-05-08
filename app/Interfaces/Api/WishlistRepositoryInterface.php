<?php

namespace App\Interfaces\Api;

use App\Models\Wishlist;
use Illuminate\Http\Request;

interface WishlistRepositoryInterface
{
    public function index(Request $request);

    public function store(Request $request);

    public function destroy(Wishlist $wishlist);
}
