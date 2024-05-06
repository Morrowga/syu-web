<?php

namespace App\Models;

use App\Traits\UUID;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quality extends Model
{
    use HasFactory, UUID;

    protected $table = 'qualities';

    protected $fillable = ['name', 'price', 'is_active', 'is_default', 'category_id'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
