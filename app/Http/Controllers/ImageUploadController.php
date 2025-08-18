<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageUploadController extends Controller {
    public function upload( Request $request ) {
        $request->validate( [
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'folder' => 'nullable|string|max:100'
        ] );

        $file = $request->file( 'image' );

        $folder = $request->input( 'folder', 'default' );
        $safeFolder = preg_replace( '/[^a-zA-Z0-9_\-]/', '', $folder );

        $uploadPath = public_path( "uploads/$safeFolder" );

        if ( !File::exists( $uploadPath ) ) {
            File::makeDirectory( $uploadPath, 0775, true );
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move( $uploadPath, $filename );

        $publicUrl = url( "uploads/$safeFolder/$filename" );

        return response(
            json_encode( [
                'message' => 'Image uploaded successfully!',
                'url' => $publicUrl
            ], JSON_UNESCAPED_SLASHES ),
            200,
            [ 'Content-Type' => 'application/json' ]
        );
    }

}
