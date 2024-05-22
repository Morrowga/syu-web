<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Wishlist;
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

    public function index(Request $request)
    {
        return $this->wishlistRepository->index($request);
    }

    public function store(WishlistCreateRequest $request)
    {
        return $this->wishlistRepository->store($request);
    }

    public function destroy(Product $product)
    {
        return $this->wishlistRepository->destroy($product);
    }
}
