<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ImageUploadHelper {
    /**
    * Upload an image to the specified directory.
    *
    * @param UploadedFile $image
    * @param string $path
    * @param string|null $disk
    * @param string|null $customName
    * @return string|false
    */
    // public static function uploadImage( UploadedFile $image, string $path = 'uploads/images', string $customName = null ) {
    //     if ( !$image->isValid() ) {
    //         return false;
    //     }

    //     $filename = $customName ?: Str::random( 20 ) . '.' . $image->getClientOriginalExtension();

    //     $destinationPath = public_path( $path );

    //     if ( !file_exists( $destinationPath ) ) {
    //         mkdir( $destinationPath, 0755, true );
    //     }

    //     $image->move( $destinationPath, $filename );

    //     return 'public/' . $path . '/' . $filename;
    //     // relative to public folder
    // }
    public static function uploadImage( UploadedFile $image, string $path = 'uploads/images', string $customName = null ) {
        if ( !$image->isValid() ) {
            return false;
        }

        $filename = $customName ?: Str::random( 20 ) . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path( $path );

        if ( !file_exists( $destinationPath ) ) {
            mkdir( $destinationPath, 0755, true );
        }

        $image->move( $destinationPath, $filename );

        return $path . '/' . $filename;
        // Adjust this if needed based on your URL structure
    }

    /**
    * Delete an image from storage.
    *
    * @param string $filePath
    * @param string $disk
    * @return bool
    */
    public static function deleteImage( string $filePath, string $disk = 'public' ) {
        if ( Storage::disk( $disk )->exists( $filePath ) ) {
            return Storage::disk( $disk )->delete( $filePath );
        }

        return false;
    }
}