<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
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
            "size" => $this->size,
            "price" => $this->price,
            "category_id" => $this->category_id,
            "is_default" => $this->is_default,
            "is_active" => $this->is_active,
        ];
    }
}
