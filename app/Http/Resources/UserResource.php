<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "points" => $this->points,
            "msisdn" => $this->msisdn,
            "shipping_address" => $this->shipping_address,
            "gender" => $this->gender,
            "is_above_eighteen" => $this->is_above_eighteen,
            "is_active" => $this->is_active,
            "shippingcity" => $this->shippingcity,
            "extra_address" => $this->extra_address
        ];
    }
}
