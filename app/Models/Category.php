<?php

namespace App\Models;

use App\Models\Size;
use App\Traits\UUID;
use App\Models\Quality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, UUID;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $table = 'categories';

    protected $fillable = ['name', 'is_active', 'waiting_days', 'limitation'];

    public function qualities()
    {
        return $this->hasMany(Quality::class);
    }

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
}
