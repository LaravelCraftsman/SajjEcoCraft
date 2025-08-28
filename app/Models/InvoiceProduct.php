<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model {

    protected $fillable = [
        'invoice_id',
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

    public function invoice() {
        return $this->belongsTo( Invoice::class );
    }

    public function product() {
        return $this->belongsTo( Product::class );
    }
}
