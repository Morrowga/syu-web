<?php

namespace App\Models;

use App\Traits\UUID;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements HasMedia
{
    use HasFactory, UUID, InteractsWithMedia;


    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'waiting_start_date',
        'waiting_end_date',
        'total_price',
        'note',
        'order_detail',
        'order_expired_date',
        'paid_delivery_cost',
        'order_status'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->getFirstMedia('images')) {
            return $this->getFirstMedia('images')->getUrl();
        }

        return null;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product');
    }

}
