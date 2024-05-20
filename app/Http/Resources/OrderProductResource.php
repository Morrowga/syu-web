<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SizeResource;
use App\Http\Resources\QualityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            "is_active" => $this->true,
            "created_at" => $this->created_at,
            "image_url" => $this->image_url,
            "size" => new SizeResource($this->pivot->size),
            "quality" => new QualityResource($this->pivot->quality),
            "total_amt" => calculate_product_price($this->pivot->size->price, $this->pivot->quality->price)
        ];
    }
}
