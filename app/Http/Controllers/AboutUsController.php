<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller {
    public function index() {
        $description = AboutUs::find( 1 );
        return view( 'about_us.index', compact( 'description' ) );
    }

    public function store( Request $request ) {
        $description = AboutUs::find( 1 );
        $description->description = $request->input( 'description' );
        $description->save();

        return redirect()->route( 'about_us' )->with( 'status', 'About description updated successfully.' );
    }
}
