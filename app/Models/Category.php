<?php

namespace App\Models;

use App\Models\Size;
use App\Traits\UUID;
use App\Models\Product;
use App\Models\Quality;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model implements HasMedia
{
    use HasFactory, UUID, InteractsWithMedia;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $table = 'categories';

    protected $fillable = ['name', 'is_active', 'waiting_days', 'limitation'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->getFirstMedia('images')) {
            return $this->getFirstMedia('images')->getUrl();
        }

        return null;
    }

    public function qualities()
    {
        return $this->hasMany(Quality::class);
    }

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
