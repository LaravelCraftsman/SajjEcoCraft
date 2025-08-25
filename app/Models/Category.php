<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
    * Automatically generate slug when setting the name.
    */

    public function setNameAttribute( $value ) {
        $this->attributes[ 'name' ] = $value;

        $baseSlug = Str::slug( $value );
        $slug = $baseSlug;
        $counter = 1;

        while ( Category::withTrashed()->where( 'slug', $slug )->exists() ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $this->attributes[ 'slug' ] = $slug;
    }

    /**
    * Get all products that belong to this category.
    */

    public function products() {
        return $this->hasMany( Product::class );
    }
}