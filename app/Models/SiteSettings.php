<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model {
    use HasFactory;
    protected $table = 'site_settings';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'title', 'tag_line', 'logo_light_image', 'logo_dark_image', 'favicon_image',
        'phone_number', 'email_address', 'address', 'description',
        'facebook', 'youtube', 'linkedin', 'instagram',
        'meta_description', 'meta_keywords', 'meta_author', 'canonical_url',
        'og_title', 'og_description', 'og_image', 'og_url', 'og_type', 'og_site_name',
        'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
        'twitter_url', 'twitter_site', 'twitter_creator',
        'latitude', 'longitude', 'map_link',
        'gst', 'account_holder_name', 'bank_name', 'account_number',
        'ifsc_code', 'bank_address', 'account_type', 'upi_id', 'upi_number', 'upi_qr_code_image'
    ];

    // For timestamp fields
    public $timestamps = true;
}
