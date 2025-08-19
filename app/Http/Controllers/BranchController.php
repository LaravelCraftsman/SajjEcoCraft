<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller {
    public function index() {
        $branches = Branch::latest()->get();
        return view( 'branches.index', compact( 'branches' ) );
    }

    public function create() {
        return view( 'branches.create' );
    }

    public function store( Request $request ) {
        $validated = $request->validate( [
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'email_address' => 'required|email',
            'phone_number' => 'required|string|max:20',
        ] );

        Branch::create( $validated );

        return redirect()->route( 'branches.index' )->with( 'status', 'Branch created successfully!' );
    }

    public function edit( $id ) {
        $branch = Branch::findOrFail( $id );
        return view( 'branches.edit', compact( 'branch' ) );
    }

    public function update( Request $request, $id ) {
        $branch = Branch::findOrFail( $id );

        $validated = $request->validate( [
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'email_address' => 'required|email',
            'phone_number' => 'required|string|max:20',
        ] );

        $branch->update( $validated );

        return redirect()->route( 'branches.index' )->with( 'status', 'Branch updated successfully!' );
    }

    public function destroy( $id ) {
        $branch = Branch::findOrFail( $id );
        $branch->delete();

        return redirect()->route( 'branches.index' )->with( 'status', 'Branch deleted successfully!' );
    }
}