<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $faqs = Faq::latest()->paginate( 10 );
        return view( 'faqs.index', compact( 'faqs' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'faqs.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        $request->validate( [
            'question' => 'required|string',
            'answer' => 'required|string',
        ] );

        $faq = new Faq();
        $faq->question = $request->input( 'question' );
        $faq->answer = $request->input( 'answer' );
        $faq->save();

        return redirect()->route( 'faqs.index' )->with( 'success', 'FAQ created successfully.' );
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

    public function edit( Faq $faq ) {
        return view( 'faqs.edit', compact( 'faq' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $request->validate( [
            'question' => 'required|string',
            'answer' => 'required|string',
        ] );

        $faq =  Faq::findorFail( $id );
        $faq->question = $request->input( 'question' );
        $faq->answer = $request->input( 'answer' );
        $faq->save();

        return redirect()->route( 'faqs.index' )->with( 'success', 'FAQ updated successfully.' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $faq =  Faq::findorFail( $id );
        $faq->delete();
        return redirect()->route( 'faqs.index' )->with( 'success', 'FAQ deleted successfully.' );
    }
}