<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'status',
        'stock',
        'purchase_price',
        'selling_price',
        'discounted_price',
        'category_id',
        'vendor_id',
        'images',
        'main_image',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    /**
    * Automatically generate slug when name is set.
    */

    public function setNameAttribute( $value ) {
        $this->attributes[ 'name' ] = $value;

        // Avoid slug conflict including soft deleted
        $baseSlug = Str::slug( $value );
        $slug = $baseSlug;
        $count = 1;

        while ( self::withTrashed()->where( 'slug', $slug )->exists() ) {
            $slug = $baseSlug . '-' . $count++;
        }

        $this->attributes[ 'slug' ] = $slug;
    }

    /**
    * Category relationship
    */

    public function category() {
        return $this->belongsTo( Category::class );
    }

    /**
    * Vendor relationship
    */

    public function vendor() {
        return $this->belongsTo( Vendor::class );
    }

    /**
    * Get the primary image ( first in array or main_image )
    */

    public function getPrimaryImageAttribute() {
        return $this->main_image ?? ( $this->images[ 0 ] ?? null );
    }

    // In your Product model

    public function getImagesAttribute( $value ) {
        if ( empty( $value ) ) {
            return [];
        }

        return json_decode( $value, true );
    }
}
