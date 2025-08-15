<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'tag',
        'cta_label',
        'cta_url',
        'image',
        'status',
    ];
}