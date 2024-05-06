<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    private WishlistRepositoryInterface $wishlistRepository;

    public function __construct(WishlistRepositoryInterface $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    public function createWishlist(WishlistCreateRequest $request)
    {
        return $this->wishlistRepository->createWishlist($request);
    }
}
