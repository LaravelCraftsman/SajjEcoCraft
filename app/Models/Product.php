<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\InvoiceProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Basic Info
        'name',
        'slug',
        'description',
        'short_description',
        'unique_id',
        'pinned',
        'size',

        // Inventory & Pricing
        'sku',
        'status',
        'stock',
        'purchase_price',
        'profit',
        'discount',
        'selling_price',

        // Relationships
        'category_id',
        'vendor_id',

        // Images
        'images',
        'main_image',

        // SEO
        'meta_description',
        'meta_keywords',

        // OG Meta
        'og_title',
        'og_description',
        'og_image',

        // Twitter Meta
        'twitter_title',
        'twitter_description',
        'twitter_image',
    ];

    protected $casts = [
        'images' => 'array',
        'pinned' => 'boolean',
        'purchase_price' => 'decimal:2',
        'profit' => 'decimal:2',
        'discount' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    /**
    * Automatically generate slug when name is set
    */

    public function setNameAttribute( $value ) {
        $this->attributes[ 'name' ] = $value;

        $baseSlug = Str::slug( $value );
        $slug = $baseSlug;
        $count = 1;

        // Check even for soft deleted records
        while ( self::withTrashed()->where( 'slug', $slug )->exists() ) {
            $slug = $baseSlug . '-' . $count++;
        }

        $this->attributes[ 'slug' ] = $slug;
    }

    /**
    * Category Relationship
    */

    public function category() {
        return $this->belongsTo( Category::class );
    }

    /**
    * Vendor Relationship
    */

    public function vendor() {
        return $this->belongsTo( Vendor::class );
    }

    /**
    * Get the primary image ( either main_image or the first in images array )
    */

    public function getPrimaryImageAttribute() {
        return $this->main_image ?? ( $this->images[ 0 ] ?? null );
    }

    /**
    * Accessor for images as array
    */

    public function getImagesAttribute( $value ) {
        return !empty( $value ) ? json_decode( $value, true ) : [];
    }

    /**
    * Mutator for images to store as JSON
    */

    public function setImagesAttribute( $value ) {
        $this->attributes[ 'images' ] = is_array( $value ) ? json_encode( $value ) : $value;
    }

    // In Product.php

    public function invoiceProducts() {
        return $this->hasMany( InvoiceProduct::class );
    }

}