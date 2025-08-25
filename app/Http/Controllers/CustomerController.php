<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\CustomerExport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $customers = User::where( 'role', 'customer' )->get();
        return view( 'customers.index', compact( 'customers' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'customers.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        $validated = $request->validate( [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
        ] );

        // Create new User instance
        $user = new User();

        $user->name = $validated[ 'name' ];
        $user->email = $validated[ 'email' ];
        $user->phone = $validated[ 'phone' ];
        $user->password = Hash::make( 'password' );
        $user->role = 'customer';

        $user->save();

        // Redirect with success message
        return redirect()->route( 'customers.index' )->with( 'status', 'Customer user created successfully.' );

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
        $customer =  User::findorFail( $id );
        return view( 'customers.edit', compact( 'customer' ) );

    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $validated = $request->validate( [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'phone'    => 'required|string|max:20',
        ] );

        // Create new User instance
        $user =  User::findorFail( $id );

        $user->name = $validated[ 'name' ];
        $user->email = $validated[ 'email' ];
        $user->phone = $validated[ 'phone' ];
        $user->password = Hash::make( 'password' );
        $user->role = 'customer';

        $user->save();

        // Redirect with success message
        return redirect()->route( 'customers.index' )->with( 'status', 'Customer user updated successfully.' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $user =  User::findorFail( $id );
        $user->delete();

        // Redirect with success message
        return redirect()->route( 'customers.index' )->with( 'status', 'Customer user deleted successfully.' );
    }

    public function export() {
        return Excel::download( new CustomerExport, 'customer-users.xlsx' );
    }
}