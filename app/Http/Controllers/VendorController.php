<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $vendors = Vendor::latest()->get();
        return view( 'vendors.index', compact( 'vendors' ) );
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'vendors.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        $request->validate( [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'phone' => 'required|string|unique:vendors,phone',
            'address' => 'required|string',
            'company_name' => 'required|string',
            'company_website' => 'nullable|url|unique:vendors,company_website',
            'gst' => 'nullable|string|unique:vendors,gst',
            'account_holder_name' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'bank_address' => 'nullable|string',
            'account_type' => 'nullable|string',
            'parking_charges' => 'nullable|string',
            'operational_charges' => 'nullable|string',
            'transport' => 'nullable|string',
            'dead_stock' => 'nullable|string',
            'branding' => 'nullable|string',
            'damage_and_shrinkege' => 'nullable|string',
            'profit' => 'nullable|string',
        ] );

        $vendor = new Vendor();

        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->company_name = $request->company_name;
        $vendor->company_website = $request->company_website;
        $vendor->gst = $request->gst;
        $vendor->account_holder_name = $request->account_holder_name;
        $vendor->bank_name = $request->bank_name;
        $vendor->account_number = $request->account_number;
        $vendor->ifsc_code = $request->ifsc_code;
        $vendor->bank_address = $request->bank_address;
        $vendor->account_type = $request->account_type;
        $vendor->parking_charges = $request->parking_charges;
        $vendor->operational_charges = $request->operational_charges;
        $vendor->transport = $request->transport;
        $vendor->dead_stock = $request->dead_stock;
        $vendor->branding = $request->branding;
        $vendor->damage_and_shrinkege = $request->damage_and_shrinkege;
        $vendor->profit = $request->profit;

        $vendor->save();

        return redirect()->route( 'vendors.index' )->with( 'success', 'Vendor created successfully.' );
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
        $vendor = Vendor::findOrFail( $id );
        return view( 'vendors.edit', compact( 'vendor' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $vendor = Vendor::findOrFail( $id );

        $request->validate( [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'phone' => 'required|string|unique:vendors,phone,' . $vendor->id,
            'address' => 'required|string',
            'company_name' => 'required|string',
            'company_website' => 'nullable|url|unique:vendors,company_website,' . $vendor->id,
            'gst' => 'nullable|string|unique:vendors,gst,' . $vendor->id,
            'account_holder_name' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'bank_address' => 'nullable|string',
            'account_type' => 'nullable|string',
            'parking_charges' => 'nullable|string',
            'operational_charges' => 'nullable|string',
            'transport' => 'nullable|string',
            'dead_stock' => 'nullable|string',
            'branding' => 'nullable|string',
            'damage_and_shrinkege' => 'nullable|string',
            'profit' => 'nullable|string',
        ] );

        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->company_name = $request->company_name;
        $vendor->company_website = $request->company_website;
        $vendor->gst = $request->gst;
        $vendor->account_holder_name = $request->account_holder_name;
        $vendor->bank_name = $request->bank_name;
        $vendor->account_number = $request->account_number;
        $vendor->ifsc_code = $request->ifsc_code;
        $vendor->bank_address = $request->bank_address;
        $vendor->account_type = $request->account_type;
        $vendor->parking_charges = $request->parking_charges;
        $vendor->operational_charges = $request->operational_charges;
        $vendor->transport = $request->transport;
        $vendor->dead_stock = $request->dead_stock;
        $vendor->branding = $request->branding;
        $vendor->damage_and_shrinkege = $request->damage_and_shrinkege;
        $vendor->profit = $request->profit;

        $vendor->save();

        return redirect()->route( 'vendors.index' )->with( 'success', 'Vendor updated successfully.' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $vendor = Vendor::findOrFail( $id );
        $vendor->delete();

        return redirect()->route( 'vendors.index' )->with( 'success', 'Vendor deleted successfully.' );
    }
}
