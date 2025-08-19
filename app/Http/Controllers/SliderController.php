<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;

class SliderController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $sliders = Slider::latest()->get();
        return view( 'sliders.index', compact( 'sliders' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'sliders.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        $request->validate( [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'tag'         => 'nullable|string|max:255',
            'cta_label'   => 'nullable|string|max:255',
            'cta_url'     => 'nullable|url|max:255',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ] );

        $slider = new Slider();
        $slider->title       = $request->input( 'title' );
        $slider->description = $request->input( 'description' );
        $slider->tag         = $request->input( 'tag' );
        $slider->cta_label   = $request->input( 'cta_label' );
        $slider->cta_url     = $request->input( 'cta_url' );
        $slider->status      = $request->input( 'status' );

        if ( $request->hasFile( 'image' ) ) {
            try {
                $slider->image = ImageUploadHelper::upload( $request->file( 'image' ), 'sliders' );
            } catch ( Exception $e ) {
                return back()->withErrors( [ 'image' => $e->getMessage() ] )->withInput();
            }
        }

        $slider->save();

        return redirect()->route( 'sliders.index' )->with( 'status', 'Slider created successfully!' );
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        $slider = Slider::findOrFail( $id );
        return view( 'sliders.edit', compact( 'slider' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $slider = Slider::findOrFail( $id );

        $request->validate( [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'tag'         => 'nullable|string|max:255',
            'cta_label'   => 'nullable|string|max:255',
            'cta_url'     => 'nullable|url|max:255',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ] );

        $slider->title       = $request->input( 'title' );
        $slider->description = $request->input( 'description' );
        $slider->tag         = $request->input( 'tag' );
        $slider->cta_label   = $request->input( 'cta_label' );
        $slider->cta_url     = $request->input( 'cta_url' );
        $slider->status      = $request->input( 'status' );

        if ( $request->hasFile( 'image' ) ) {
            try {
                $slider->image = ImageUploadHelper::upload( $request->file( 'image' ), 'sliders' );
            } catch ( \Exception $e ) {
                return back()->withErrors( [ 'image' => $e->getMessage() ] )->withInput();
            }
        }

        $slider->save();

        return redirect()->route( 'sliders.index' )->with( 'status', 'Slider updated successfully!' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $slider = Slider::findOrFail( $id );
        $slider->delete();

        return redirect()->route( 'sliders.index' )->with( 'status', 'Slider deleted successfully!' );
    }
}
