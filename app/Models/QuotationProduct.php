<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationProduct extends Model {
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'product_id',
        'quantity',
        'rate',
        'amount',
        'image'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function quotation() {
        return $this->belongsTo( Quotation::class );
    }

    public function product() {
        return $this->belongsTo( Product::class );
    }
}
