<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "waiting_days" => $this->waiting_days,
            "is_active" => $this->is_active,
            "sizes" => $this->sizes,
            "qualities" => $this->qualities
        ];
    }
}
