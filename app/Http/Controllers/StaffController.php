<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $staff = User::where( 'role', 'staff' )->get();
        return view( 'staff.index', compact( 'staff' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'staff.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        // Validate the input data
        $validated = $request->validate( [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ] );

        // Create new User instance
        $user = new User();

        $user->name = $validated[ 'name' ];
        $user->email = $validated[ 'email' ];
        $user->phone = $validated[ 'phone' ];
        $user->password = Hash::make( $validated[ 'password' ] );
        $user->role = 'staff';
        // fixed role

        // Set permissions based on checkbox inputs ( true if checked, false if not )
        $user->create = $request->has( 'create' );
        $user->edit = $request->has( 'edit' );
        $user->delete = $request->has( 'delete' );

        // Save user to database
        $user->save();

        // Redirect with success message
        return redirect()->route( 'staff.index' )->with( 'status', 'Staff user created successfully.' );

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
        $staff = User::findorFail( $id );
        return view( 'staff.edit', compact( 'staff' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $user = User::findOrFail( $id );

        $validated = $request->validate( [
            'name'  => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'phone' => 'required|string|max:14',
            'password' => 'nullable|string|min:6',
        ] );

        $user->name = $validated[ 'name' ];
        $user->email = $validated[ 'email' ];
        $user->phone = $validated[ 'phone' ];

        if ( !empty( $validated[ 'password' ] ) ) {
            $user->password = Hash::make( $validated[ 'password' ] );
        }

        // Ensure boolean values — set to true if present, otherwise false
        $user->create = $request->has( 'create' ) ? true : false;
        $user->edit = $request->has( 'edit' ) ? true : false;
        $user->delete = $request->has( 'delete' ) ? true : false;

        $user->save();

        return redirect()->route( 'staff.index' )->with( 'status', 'Staff updated successfully!' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $user = User::findOrFail( $id );
        $user->delete();

        return redirect()->route( 'staff.index' )->with( 'status', 'Staff user deleted successfully!' );
    }
}
