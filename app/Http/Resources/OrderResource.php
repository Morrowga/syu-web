<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrderProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "order_no" => $this->order_no,
            "user_id" => $this->user_id,
            "user" => new UserResource($this->user->load('shippingcity')),
            "waiting_start_date" => $this->waiting_start_date,
            "waiting_end_date" => $this->waiting_end_date,
            "total_price" => $this->total_price,
            "overall_price" => $this->overall_price,
            "note" => $this->note,
            "order_expired_date" => $this->order_expired_date,
            "paid_delivery_cost" => $this->paid_delivery_cost,
            "is_paid" => $this->is_paid,
            "payment_method" => $this->payment_method,
            "order_status" => $this->order_status,
            "created_at" => $this->created_at,
            "image_url" => $this->image_url,
            "count" => $this->products->count(),
            "products" => OrderProductResource::collection($this->products),
        ];
    }
}
