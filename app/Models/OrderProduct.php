<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function quality()
    {
        return $this->belongsTo(Quality::class, 'quality_id');
    }
}
