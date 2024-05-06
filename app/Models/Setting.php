<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'settings';

    protected $fillable = ['splash_slogan', 'app_bg_color', 'app_text_color', 'app_button_color'];

    protected $appends = ['images'];

    public function getImagesAttribute()
    {
        $bannerImages = $this->getMedia('banners');

        $imageUrls = $bannerImages->map(function ($mediaItem) {
            return [
                "image" => $mediaItem->getUrl(),
                "id" => $mediaItem->id
            ];
        })->toArray();

        return $imageUrls;
    }
}
