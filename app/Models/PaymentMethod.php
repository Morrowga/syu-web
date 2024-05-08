<?php

namespace App\Models;

use App\Traits\UUID;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model implements HasMedia
{
    use HasFactory, UUID, InteractsWithMedia;

    protected $table = 'payment_methods';

    protected $fillable = ['name', 'is_active', 'value'];

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
}
