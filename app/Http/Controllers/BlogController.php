<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;

class BlogController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $blogs = Blog::orderBy( 'created_at', 'desc' )->paginate( 10 );
        return view( 'blogs.index', compact( 'blogs' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'blogs.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string',
            'content'    => 'required|string',
            'main_image' => 'required', // Assuming you're saving image URL or path manually
        ]);
         $blog = new Blog();

    $request->validate([
        'title'       => 'required|string|max:255',
        'content'     => 'required|string',
        'main_image'  => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Update title and slug
    $blog->title = $request->input('title');
    $blog->slug = \Illuminate\Support\Str::slug($request->input('title'));

    // Update content
    $blog->content = $request->input('content');

    // Handle image upload if provided
    if ($request->hasFile('main_image')) {
        $imagePath = \App\Helpers\ImageUploadHelper::upload($request->file('main_image'), 'blogs');
        $blog->main_image = $imagePath;
    }

    // Save changes
    $blog->save();

    return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');

        // $blog = new Blog();
        // $blog->title = $validated['title'];
        // $blog->content = $validated['content'];
        // $blog->main_image = $validated['main_image'];
        // $blog->slug = Str::slug($validated['title']) . '-' . uniqid(); // unique slug
        // $blog->save();

        // return redirect()->route('blogs.index')->with('status', 'Blog created successfully!');
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

   public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.edit', compact('blog'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

   public function update(Request $request, $id)
{
    $blog = Blog::findOrFail($id);

    $request->validate([
        'title'       => 'required|string|max:255',
        'content'     => 'required|string',
        'main_image'  => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Update title and slug
    $blog->title = $request->input('title');
    $blog->slug = \Illuminate\Support\Str::slug($request->input('title'));

    // Update content
    $blog->content = $request->input('content');

    // Handle image upload if provided
    if ($request->hasFile('main_image')) {
        $imagePath = \App\Helpers\ImageUploadHelper::upload($request->file('main_image'), 'blogs');
        $blog->main_image = $imagePath;
    }

    // Save changes
    $blog->save();

    return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
}


    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
 public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function uploadImage( Request $request ) {
        if ( $request->hasFile( 'upload' ) ) {
            try {
                $uploadedUrl = ImageUploadHelper::upload( $request->file( 'upload' ), 'ckeditor' );
                // save in public/uploads/ckeditor
                $CKEditorFuncNum = $request->input( 'CKEditorFuncNum' );
                $msg = 'Image uploaded successfully';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$uploadedUrl', '$msg');</script>";

                @header( 'Content-type: text/html; charset=utf-8' );
                echo $response;
            } catch ( Exception $e ) {
                echo "<script>alert('Upload failed: " . $e->getMessage() . "');</script>";
            }
        }
    }

}
