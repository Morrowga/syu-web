<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UUID;
use App\Models\Product;
use App\Models\ShippingCity;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'msisdn',
        'gender',
        'shipping_city_id',
        'shipping_address',
        'is_active',
        'points',
        'is_above_eighteen',
        'extra_address'
    ];

    protected $appends = ['avatar'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAvatarAttribute()
    {
        return 'https://ui-avatars.com/api/?name=' . $this->name .'&size=128';
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_above_eighteen' => 'boolean',
        'is_active' => 'boolean'
    ];


    public function wishlists()
    {
        return $this->belongsToMany(Product::class, 'wishlists');
    }

    public function shippingcity()
    {
        return $this->belongsTo(ShippingCity::class, 'shipping_city_id');
    }
}
