<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OTP extends Model
{
    use HasFactory, UUID;

    protected $table = 'o_t_p_s';

    protected $dates = ['expires_at'];

    protected $fillable = ['otp', 'msisdn', 'expires_at'];
}
