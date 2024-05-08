<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingCity extends Model
{
    use HasFactory, UUID;

    protected $table = 'shipping_cities';

    protected $fillable = ['name_en','name_mm', 'cost', 'is_active'];

    public $timestamps = false;

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
