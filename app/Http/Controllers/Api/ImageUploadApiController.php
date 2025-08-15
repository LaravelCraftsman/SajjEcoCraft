<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;

class ImageUploadApiController extends Controller {
    public function upload( Request $request ) {
        // Validate image
        $request->validate( [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ] );

        // Upload image using helper
        $imagePath = ImageUploadHelper::uploadImage( $request->file( 'image' ), 'uploads/images' );

        if ( !$imagePath ) {
            return response()->json( [
                'success' => false,
                'message' => 'Image upload failed.'
            ], 500 );
        }

        // Return success with image URL
        return response()->json( [
            'success' => true,
            'message' => 'Image uploaded successfully.',
            'image_url' => url( $imagePath )  // full URL for accessing image
        ] );
    }
}