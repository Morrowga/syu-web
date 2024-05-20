<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UUID;
use App\Models\Product;
use App\Models\OrderProduct;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements HasMedia
{
    use HasFactory, UUID, InteractsWithMedia;


    protected $table = 'orders';

    protected $fillable = [
        'order_no',
        'user_id',
        'waiting_start_date',
        'waiting_end_date',
        'total_price',
        'note',
        'is_paid',
        'overall_price',
        'payment_method',
        'order_expired_date',
        'paid_delivery_cost',
        'order_status'
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'paid_delivery_cost' => 'boolean'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->getFirstMedia('images')) {
            return $this->getFirstMedia('images')->getUrl();
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
        ->withPivot('size_id', 'quality_id')
        ->using(OrderProduct::class);
    }

}
