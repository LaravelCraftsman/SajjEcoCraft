<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactRequest;

class ContactRequestController extends Controller {
    // Display all contact requests

    public function index() {
        $contactRequests = ContactRequest::paginate( 10 );
        // 10 items per page
        return view( 'contact_requests.index', compact( 'contactRequests' ) );
    }

    // Show form to create a new contact request

    public function create() {
        return view( 'contact_requests.create' );
    }

    // Store a newly created contact request

    public function store( Request $request ) {
        $validated = $request->validate( [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ] );

        ContactRequest::create( $validated );

        return redirect()->route( 'contactRequests.index' )->with( 'success', 'Contact request submitted successfully!' );
    }

    // Show form to edit the specified contact request

    public function edit( $id ) {
        $contactRequest = ContactRequest::findOrFail( $id );
        return view( 'contact_requests.edit', compact( 'contactRequest' ) );
    }

    // Update the specified contact request

    public function update( Request $request, $id ) {
        $contactRequest = ContactRequest::findOrFail( $id );

        $validated = $request->validate( [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ] );

        $contactRequest->update( $validated );

        return redirect()->route( 'contactRequests.index' )->with( 'success', 'Contact request updated successfully!' );
    }

    // Delete the specified contact request

    public function destroy( $id ) {
        $contactRequest = ContactRequest::findOrFail( $id );
        $contactRequest->delete();

        return redirect()->route( 'contactRequests.index' )->with( 'success', 'Contact request deleted successfully!' );
    }
}
