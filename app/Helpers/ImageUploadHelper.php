<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageUploadHelper {
    /**
    * Upload an image to a specified folder inside public/uploads.
    *
    * @param UploadedFile $file
    * @param string $folder ( e.g. 'default', 'slider' )
    * @return string URL of uploaded image
    *
    * @throws \Exception
    */
    public static function upload( UploadedFile $file, string $folder = 'default' ): string {
        // Allowed file extensions
        $allowedExtensions = [ 'jpg', 'jpeg', 'png', 'gif' ];

        $extension = strtolower( $file->getClientOriginalExtension() );

        if ( !in_array( $extension, $allowedExtensions ) ) {
            throw new \Exception( 'File type not allowed.' );
        }

        // Max size in bytes ( 2MB )
        $maxSize = 2 * 1024 * 1024;

        if ( $file->getSize() > $maxSize ) {
            throw new \Exception( 'File size exceeds 2MB limit.' );
        }

        // Generate unique filename
        $filename = ( string ) Str::uuid() . '.' . $extension;

        // Path inside public/uploads/$folder
        $path = $folder . '/' . $filename;

        // Move the uploaded file to public/uploads/$folder
        $file->move( public_path( 'uploads/' . $folder ), $filename );

        // Return public URL without /public in path
        return url( 'uploads/' . $path );
    }
}
