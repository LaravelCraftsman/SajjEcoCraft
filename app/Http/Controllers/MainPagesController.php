<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\Slider;
use App\Models\AboutUs;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class MainPagesController extends Controller {
    public function index() {
        $blogs = Blog::orderBy( 'created_at', 'desc' )->paginate( 10 );
        $sliders = Slider::orderBy( 'created_at', 'desc' )->where( 'status', 'active' )->get();
        $categoriesWithProducts = Category::has( 'products' )->get();
        $products = Product::where( 'status', 'active' )
        ->orderBy( 'pinned', 'asc' )
        ->where( 'stock', '>', 0 )
        ->orderBy( 'created_at', 'desc' ) // Sort pinned products first ( assuming 1 = pinned )
        ->take( 20 )
        ->get();
        return view( 'main_pages.index', compact( 'blogs', 'sliders', 'categoriesWithProducts', 'products' ) );
    }

    public function shop() {
        $products = Product::where( 'status', 'active' )
        ->orderBy( 'pinned', 'asc' )
        ->where( 'stock', '>', 0 )
        ->orderBy( 'created_at', 'desc' )
        ->paginate( 40 );
        $banner = Banner::find( 1 );
        $categoriesWithProducts = Category::has( 'products' )->get();
        return view( 'main_pages.shop', compact( 'products', 'banner', 'categoriesWithProducts' ) );
    }

    public function shop_detail( Request $request, $slug ) {
        $product = Product::where( 'slug', $slug )->firstOrFail();
        $categoriesWithProducts = Category::has( 'products' )->get();
        return view( 'main_pages.product_details', compact( 'categoriesWithProducts', 'product' ) );
    }

    public function about_us() {
        $description = AboutUs::find( 1 )->description;
        $categoriesWithProducts = Category::has( 'products' )->get();
        return view( 'main_pages.about_us', compact( 'description', 'categoriesWithProducts' ) );
    }

    public function blogs() {
        $blogs = Blog::paginate( 12 );
        $banner = Banner::find( 2 );
        $categoriesWithProducts = Category::has( 'products' )->get();
        return view( 'main_pages.blogs', compact( 'blogs', 'banner', 'categoriesWithProducts' ) );
    }

    public function blog_details( $slug ) {
        $blog = Blog::where( 'slug', $slug )->firstOrFail();
        $categoriesWithProducts = Category::has( 'products' )->get();
        return view( 'main_pages.blog_details', compact( 'blog', 'categoriesWithProducts' ) );
    }

    public function contact_us() {
        $branches = Branch::all();
        $categoriesWithProducts = Category::has( 'products' )->get();
        return view( 'main_pages.contact_us', compact( 'categoriesWithProducts', 'branches' ) );
    }

}
