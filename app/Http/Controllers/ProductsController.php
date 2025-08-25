<?php

namespace App\Http\Controllers;

use App\Helpers\ImageUploadHelper;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductsController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $products = Product::with( [ 'category', 'vendor' ] )->paginate( 15 );
        return view( 'products.index', compact( 'products' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        $categories = Category::all();
        $vendors = Vendor::all();
        return view( 'products.create', compact( 'categories', 'vendors' ) );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        // dd( $request );
        // Validate inputs
        $request->validate( [
            'name'              => 'required|string|max:255|unique:products,name',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string',
            'sku'               => 'required|string|unique:products,sku',
            'status'            => 'required|in:active,inactive,draft',
            'stock'             => 'nullable|integer|min:0',
            'purchase_price'    => 'required|numeric|min:0',
            'selling_price'     => 'required|numeric|min:0',
            'discounted_price'  => 'nullable|numeric|min:0',
            'category_id'       => 'nullable|exists:categories,id',
            'vendor_id'         => 'nullable|exists:vendors,id',
            'images.*'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_description'  => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string|max:255',
            'og_title'          => 'nullable|string|max:255',
            'og_description'    => 'nullable|string',
            'og_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'twitter_title'     => 'nullable|string|max:255',
            'twitter_description'=> 'nullable|string',
            'twitter_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ] );

        $product = new Product();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->sku = $request->sku;
        $product->status = $request->status;
        $product->stock = $request->stock ?? null;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->discounted_price = $request->discounted_price ?? null;
        $product->category_id = $request->category_id ?? null;
        $product->vendor_id = $request->vendor_id ?? null;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->og_title = $request->og_title;
        $product->og_description = $request->og_description;
        $product->twitter_title = $request->twitter_title;
        $product->twitter_description = $request->twitter_description;

        // Upload OG image if present
        if ( $request->hasFile( 'og_image' ) ) {
            $product->og_image = ImageUploadHelper::upload( $request->file( 'og_image' ), 'products/og_images' );
        }

        // Upload Twitter image if present
        if ( $request->hasFile( 'twitter_image' ) ) {
            $product->twitter_image = ImageUploadHelper::upload( $request->file( 'twitter_image' ), 'products/twitter_images' );
        }

        // Upload main image if present
        if ( $request->hasFile( 'main_image' ) ) {
            $product->main_image = ImageUploadHelper::upload( $request->file( 'main_image' ), 'products/main_images' );
        }

        // Handle multiple images upload
        $images = [];
        if ( $request->hasFile( 'images' ) ) {
            foreach ( $request->file( 'images' ) as $image ) {
                $images[] = ImageUploadHelper::upload( $image, 'products/images' );
            }
        }
        $product->images = $images;

        $product->save();

        return redirect()->route( 'products.index' )->with( 'success', 'Product created successfully.' );
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
        $product = Product::findOrFail( $id );

        // If you have an accessor, images will already be an array
        $images = $product->images ?? [];

        $categories = Category::all();
        $vendors = Vendor::all();

        return view( 'products.edit', compact( 'product', 'images', 'categories', 'vendors' ) );
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $product = Product::findOrFail( $id );

        // Validate inputs
        $request->validate( [
            'name'              => 'required|string|max:255|unique:products,name,' . $product->id,
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string',
            'sku'               => 'required|string|unique:products,sku,' . $product->id,
            'status'            => 'required|in:active,inactive,draft',
            'stock'             => 'nullable|integer|min:0',
            'purchase_price'    => 'required|numeric|min:0',
            'selling_price'     => 'required|numeric|min:0',
            'discounted_price'  => 'nullable|numeric|min:0',
            'category_id'       => 'nullable|exists:categories,id',
            'vendor_id'         => 'nullable|exists:vendors,id',
            'images.*'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_description'  => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string|max:255',
            'og_title'          => 'nullable|string|max:255',
            'og_description'    => 'nullable|string',
            'og_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'twitter_title'     => 'nullable|string|max:255',
            'twitter_description'=> 'nullable|string',
            'twitter_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ] );

        $product->name = $request->name;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->sku = $request->sku;
        $product->status = $request->status;
        $product->stock = $request->stock ?? null;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->discounted_price = $request->discounted_price ?? null;
        $product->category_id = $request->category_id ?? null;
        $product->vendor_id = $request->vendor_id ?? null;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->og_title = $request->og_title;
        $product->og_description = $request->og_description;
        $product->twitter_title = $request->twitter_title;
        $product->twitter_description = $request->twitter_description;

        // Upload OG image if present
        if ( $request->hasFile( 'og_image' ) ) {
            $product->og_image = ImageUploadHelper::upload( $request->file( 'og_image' ), 'products/og_images' );
        }

        // Upload Twitter image if present
        if ( $request->hasFile( 'twitter_image' ) ) {
            $product->twitter_image = ImageUploadHelper::upload( $request->file( 'twitter_image' ), 'products/twitter_images' );
        }

        // Upload main image if present
        if ( $request->hasFile( 'main_image' ) ) {
            $product->main_image = ImageUploadHelper::upload( $request->file( 'main_image' ), 'products/main_images' );
        }

        // Handle additional images upload ( append to existing images )
        $images = $product->images ?? [];
        if ( $request->hasFile( 'images' ) ) {
            foreach ( $request->file( 'images' ) as $image ) {
                $images[] = ImageUploadHelper::upload( $image, 'products/images' );
            }
        }
        $product->images = $images;

        $product->save();

        return redirect()->route( 'products.index' )->with( 'success', 'Product updated successfully.' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $product = Product::findOrFail( $id );

        // You may want to delete associated images manually here if needed

        $product->delete();

        return redirect()->route( 'products.index' )->with( 'success', 'Product deleted successfully.' );
    }

    public function uploadImage( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'error' => $validator->errors()->first()
            ], 422 );
        }

        try {
            // Store the image
            $path = $request->file( 'image' )->store( 'products', 'public' );

            // Generate a public URL for the image
            $url = Storage::disk( 'public' )->url( $path );

            return response()->json( [
                'path' => $path,
                'name' => $request->file( 'image' )->getClientOriginalName(),
                'url' => $url
            ] );
        } catch ( \Exception $e ) {
            return response()->json( [
                'error' => 'Failed to upload image: ' . $e->getMessage()
            ], 500 );
        }
    }

    /**
    * Handle image deletion via Dropzone
    */

    public function deleteImage( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'path' => 'required|string'
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'error' => $validator->errors()->first()
            ], 422 );
        }

        try {
            $path = $request->input( 'path' );

            // Check if the file exists and delete it
            if ( Storage::disk( 'public' )->exists( $path ) ) {
                Storage::disk( 'public' )->delete( $path );
            }

            return response()->json( [
                'success' => true,
                'message' => 'Image deleted successfully'
            ] );
        } catch ( \Exception $e ) {
            return response()->json( [
                'error' => 'Failed to delete image: ' . $e->getMessage()
            ], 500 );
        }
    }

    /**
    * Delete image file from storage
    */

    private function deleteImageFile( $path ) {
        if ( Storage::disk( 'public' )->exists( $path ) ) {
            Storage::disk( 'public' )->delete( $path );
        }
    }

     /**
     * Remove a specific image from a product's gallery
     */
    public function removeImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'image_index' => 'required|integer|min:0'
        ]);

        $imageIndex = $request->image_index;
        $images = $product->images ?? [];

        // Check if the index exists
        if (isset($images[$imageIndex])) {
            // Get the image path
            $imagePath = $images[$imageIndex];

            // Remove from array
            unset($images[$imageIndex]);
            $images = array_values($images); // Reindex array

            // Update product
            $product->images = $images;
            $product->save();

            // Optionally delete the physical file
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image not found'
        ], 404);
    }
}
