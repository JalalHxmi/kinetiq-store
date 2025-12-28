<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'type', 'value', 'active', 'expires_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
