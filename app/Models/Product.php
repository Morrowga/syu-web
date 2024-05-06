<?php

namespace App\Models;

use App\Traits\UUID;
use App\Models\Category;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements HasMedia
{
    use HasFactory, UUID, InteractsWithMedia;

    protected $table = 'products';

    protected $fillable = ['name', 'is_active', 'category_id'];

    protected $appends = ['image_url'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->getFirstMedia('images')) {
            return $this->getFirstMedia('images')->getUrl();
        }

        return null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
