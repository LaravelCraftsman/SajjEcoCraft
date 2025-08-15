<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;

class SliderController extends Controller {
    public function index() {
        $sliders = Slider::all();
        return view( 'sliders.index', compact( 'sliders' ) );
    }

    // Show form to create a slider

    public function create() {
        return view( 'sliders.create' );
    }

    // Store new slider

    public function store( Request $request ) {
        $request->validate( [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tag' => 'nullable|string|max:100',
            'cta_label' => 'nullable|string|max:100',
            'cta_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ] );

        $imagePath = null;
        if ( $request->hasFile( 'image' ) ) {
            $imagePath = ImageUploadHelper::uploadImage( $request->file( 'image' ), 'uploads/sliders' );
        }

        Slider::create( [
            'title' => $request->title,
            'description' => $request->description ?? '',
            'tag' => $request->tag ?? '',
            'cta_label' => $request->cta_label ?? '',
            'cta_url' => $request->cta_url ?? '',
            'status' => $request->status,
            'image' => $imagePath,
        ] );

        return redirect()->route( 'sliders.index' )->with( 'success', 'Slider created successfully.' );
    }

    // Show edit form

    public function edit( Slider $slider ) {
        return view( 'sliders.edit', compact( 'slider' ) );
    }

    // Update slider

    public function update( Request $request, Slider $slider ) {
        $request->validate( [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tag' => 'nullable|string|max:100',
            'cta_label' => 'nullable|string|max:100',
            'cta_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ] );

        $imagePath = $slider->image;

        if ( $request->hasFile( 'image' ) ) {
            // Delete old image if exists
            if ( $slider->image ) {
                ImageUploadHelper::deleteImage( $slider->image );
            }
            $imagePath = ImageUploadHelper::uploadImage( $request->file( 'image' ), 'uploads/sliders' );
        }

        $slider->update( [
            'title' => $request->title,
            'description' => $request->description ?? '',
            'tag' => $request->tag ?? '',
            'cta_label' => $request->cta_label ?? '',
            'cta_url' => $request->cta_url ?? '',
            'status' => $request->status,
            'image' => $imagePath,
        ] );

        return redirect()->route( 'sliders.index' )->with( 'success', 'Slider updated successfully.' );
    }

    // Soft delete slider

    public function destroy( Slider $slider ) {
        if ( $slider->image ) {
            ImageUploadHelper::deleteImage( $slider->image );
        }
        $slider->delete();

        return redirect()->route( 'sliders.index' )->with( 'success', 'Slider deleted successfully.' );
    }
}