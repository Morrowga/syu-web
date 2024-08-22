<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "category_id" => $this->category_id,
            "is_active" => $this->is_active,
            "image_url" => $this->image_url,
            "category" => new CategoryResource($this->category),
            "isWishlist" => $this->defineWishlist($this->id),
        ];
    }

    public function defineWishlist($productId)
    {
        $user = Auth::user();

        $wishlists = $user->wishlists->pluck('id');

        $existsInWishlist = $wishlists->contains($productId);

        return $existsInWishlist;
    }
}
