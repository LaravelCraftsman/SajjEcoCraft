<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;

class ImageUploadController extends Controller {
    /**
    * Show the image upload form.
    */

    public function create() {
        return view( 'tutorial.image-upload' );
        // Blade view for the upload form
    }

    /**
    * Handle the image upload.
    */

    public function store( Request $request ) {
        \Log::info( 'Upload request received.' );

        $request->validate( [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ] );

        if ( !$request->hasFile( 'image' ) ) {
            Log::error( 'No file found in request.' );
            return back()->with( 'error', 'No file uploaded.' );
        }

        $file = $request->file( 'image' );

        if ( !$file->isValid() ) {
            \Log::error( 'Uploaded file is not valid.' );
            return back()->with( 'error', 'Uploaded file is not valid.' );
        }

        $imagePath = ImageUploadHelper::uploadImage( $file );

        if ( !$imagePath ) {
            \Log::error( 'Image upload failed in helper.' );
            return back()->with( 'error', 'Image upload failed.' );
        }

        \Log::info( 'Image uploaded successfully: ' . $imagePath );

        return back()->with( 'success', 'Image uploaded successfully.' )->with( 'imagePath', $imagePath );
    }
}