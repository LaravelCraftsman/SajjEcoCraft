<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'type',
        'discount',
        'expires_at',
        'usage_limit',
        'times_used',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

}