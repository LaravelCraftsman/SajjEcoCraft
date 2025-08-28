<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $coupons = Coupon::latest()->paginate( 10 );
        return view( 'coupons.index', compact( 'coupons' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'coupons.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        // dd( $request );
        $request->validate( [
            'code'        => 'required|string|max:50|unique:coupons,code',
            'type'        => 'required|in:fixed,percentage',
            'discount'    => 'required|numeric|min:0',
            'expires_at'  => 'nullable|date|after_or_equal:today',
            'usage_limit' => 'nullable|integer|min:1',
        ] );

        $coupon = new Coupon();
        $coupon->code        = $request->input( 'code' );
        $coupon->type        = $request->input( 'type' );
        $coupon->discount    = $request->input( 'discount' );
        $coupon->expires_at  = $request->input( 'expires_at' );
        $coupon->usage_limit = $request->input( 'usage_limit' );
        $coupon->is_active   = true;
        $coupon->save();

        return redirect()->route( 'coupons.index' )->with( 'success', 'Coupon created successfully.' );
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
        $coupon = Coupon::findOrFail( $id );
        return view( 'coupons.edit', compact( 'coupon' ) );
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $coupon = Coupon::findOrFail( $id );

        $request->validate( [
            'code'        => "required|string|max:50|unique:coupons,code,$id",
            'type'        => 'required|in:fixed,percentage',
            'discount'    => 'required|numeric|min:0',
            'expires_at'  => 'nullable|date|after_or_equal:today',
            'usage_limit' => 'nullable|integer|min:1',
        ] );

        $coupon->code        = $request->input( 'code' );
        $coupon->type        = $request->input( 'type' );
        $coupon->discount    = $request->input( 'discount' );
        $coupon->expires_at  = $request->input( 'expires_at' );
        $coupon->usage_limit = $request->input( 'usage_limit' );
        $coupon->save();

        return redirect()->route( 'coupons.index' )->with( 'success', 'Coupon updated successfully.' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        Coupon::findOrFail( $id )->delete();
        return redirect()->route( 'coupons.index' )->with( 'success', 'Coupon deleted successfully.' );
    }
}
