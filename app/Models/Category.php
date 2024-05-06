<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, UUID;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $table = 'categories';

    protected $fillable = ['name', 'is_active', 'waiting_days'];
}
