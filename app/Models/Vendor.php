<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'vendors';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company_name',
        'company_website',
        'gst',
        'account_holder_name',
        'bank_name',
        'account_number',
        'ifsc_code',
        'bank_address',
        'account_type',
        'parking_charges',
        'operational_charges',
        'transport',
        'dead_stock',
        'branding',
        'damage_and_shrinkege', // Note: consider fixing spelling here in both DB & code
        'profit',
    ];

    public function getTotalChargesAttribute() {
        return
        ( $this->parking_charges ?? 0 ) +
        ( $this->operational_charges ?? 0 ) +
        ( $this->transport ?? 0 ) +
        ( $this->dead_stock ?? 0 ) +
        ( $this->branding ?? 0 ) +
        ( $this->damage_and_shrinkege ?? 0 ) +
        ( $this->profit ?? 0 );
    }
}