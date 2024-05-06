<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistCreateRequest;
use App\Interfaces\Api\WishlistRepositoryInterface;

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
