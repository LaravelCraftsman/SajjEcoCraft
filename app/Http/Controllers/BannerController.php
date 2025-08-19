<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;

class BannerController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $aboutBanner = Banner::find( 1 );
        $blogBanner = Banner::find( 2 );

        return view( 'banners.index', compact( 'aboutBanner', 'blogBanner' ) );
    }

    public function updateAbout( Request $request ) {
        // dd( $request );
        $banner = Banner::find( 1 );

        if ( !$banner ) {
            return redirect()->route( 'banners' )->with( 'error', 'About Banner not found.' );
        }

        if ( $request->hasFile( 'image' ) ) {
            $image_path = ImageUploadHelper::upload( $request->file( 'image' ), 'images/banners' );
            $banner->image = $image_path;
            $banner->save();
        }

        return redirect()->route( 'banners' )->with( 'status', 'About Banner updated successfully.' );
    }

    public function updateBlog( Request $request ) {
        $banner = Banner::find( 2 );

        if ( !$banner ) {
            return redirect()->route( 'banners' )->with( 'error', 'Blog Banner not found.' );
        }

        if ( $request->hasFile( 'image' ) ) {
            $image_path = ImageUploadHelper::upload( $request->file( 'image' ), 'images/banners' );
            $banner->image = $image_path;
            $banner->save();
        }

        return redirect()->route( 'banners' )->with( 'status', 'Blog Banner updated successfully.' );
    }
}
