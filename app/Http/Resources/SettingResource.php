<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            "splash_slogan" => $this->splash_slogan,
            "app_bg_color" => $this->app_bg_color,
            "app_text_color" => $this->app_text_color,
            "app_button_color" => $this->app_button_color,
            "banners" => $this->images,
        ];
    }
}
