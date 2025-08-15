<?php

namespace App\Http\Controllers;

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
        // Validate image input
        $request->validate( [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ] );

        // Upload image using the helper
        $imagePath = ImageUploadHelper::uploadImage( $request->file( 'image' ), 'uploads/images', 'public' );

        if ( !$imagePath ) {
            return back()->with( 'error', 'Image upload failed.' );
        }

        // Optionally save to DB ( example )
        // $user = auth()->user();
        // $user->profile_image = $imagePath;
        // $user->save();

        return back()->with( 'success', 'Image uploaded successfully.' )->with( 'imagePath', $imagePath );
    }
}