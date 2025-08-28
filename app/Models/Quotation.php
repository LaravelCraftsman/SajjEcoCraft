<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'quotation_number',
        'quotation_date',
        'total_amount',
        'status',
        'notes',
        'coupon_id',       // Added coupon_id
        'coupon_type',     // Added coupon_type
        'coupon_value',    // Added coupon_value
    ];

    protected $casts = [
        'quotation_date' => 'date',
        'total_amount' => 'decimal:2',
        'coupon_value' => 'decimal:2',  // Cast coupon_value as decimal
    ];

    // Status constants
    public const STATUS_DRAFT = 'draft';
    public const STATUS_SENT = 'sent';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELLED = 'cancelled';

    // Relationships

    public function customer() {
        return $this->belongsTo( User::class );
    }

    public function products() {
        return $this->hasMany( QuotationProduct::class );
    }

    public function coupon() {
        return $this->belongsTo( Coupon::class );
    }

    // Recalculate total from products

    public function calculateTotal() {
        $this->total_amount = $this->products->sum( 'amount' );
        $this->save();
    }

    /**
    * Calculate the discount amount based on the coupon applied
    * Returns discount amount as float
    */

    public function calculateDiscountAmount(): float {
        if ( !$this->coupon_id || !$this->coupon_value || !$this->coupon_type ) {
            return 0.0;
        }

        if ( $this->coupon_type === 'percentage' ) {
            return round( ( $this->total_amount * $this->coupon_value ) / 100, 2 );
        }

        // Fixed discount
        return min( $this->coupon_value, $this->total_amount );
    }

    /**
    * Calculate final amount after discount
    */

    public function finalAmount(): float {
        $discount = $this->calculateDiscountAmount();
        return round( max( $this->total_amount - $discount, 0 ), 2 );
    }
}
