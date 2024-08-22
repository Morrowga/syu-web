<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use UUID;

    protected $table = 'transactions';

    protected $fillable = [
        'account_name',
        'transaction_id',
        'payment_method',
        'order_id'
    ];
}
