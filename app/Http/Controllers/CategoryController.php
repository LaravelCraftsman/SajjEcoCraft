<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Category;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $categories = Category::orderBy( 'created_at', 'desc' )->paginate( 10 );
        return view( 'categories.index', compact( 'categories' ) );
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'categories.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        $request->validate( [
            'name' => [
                'required',
                'max:255',
                Rule::unique( 'categories' )->whereNull( 'deleted_at' ),
            ],
        ] );

        $category = new Category();
        $category->name = $request->name;
        // slug will be generated in the model's setNameAttribute
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.' );
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
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category' ) );
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
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.' );
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

  public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.' );
    }


    public function downloadPdf($id) {
    $category = Category::with('products' )->findOrFail( $id );
    $logo = SiteSettings::findOrFail(1)->logo_dark_image;
        // dd($logo);
        $products = $category->products;

        $html = View::make('pdf.products', compact('products','logo'))->render();

        // Create mPDF instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
        ]);

        // Set default font if needed (e.g. for Unicode)
        $mpdf->SetFont('dejavusans');

        // Write the HTML
        $mpdf->WriteHTML($html);

return response($mpdf->Output('', 'S'), 200)
    ->header('Content-Type', 'application/pdf')
    ->header(
        'Content-Disposition',
        'inline; filename="products.pdf"'
    );

    }

}