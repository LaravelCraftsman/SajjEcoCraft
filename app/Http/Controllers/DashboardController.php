<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Quotation;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function index() {
        $data = [
            'totalUsers'      => User::count(),
            'totalProducts'   => Product::count(),
            'totalInvoices'   => Invoice::count(),
            'totalQuotations' => Quotation::count(),
            'totalRevenue'    => Invoice::sum( 'total_amount' ),
            'activeCoupons'   => Coupon::where( 'is_active', true )->count(),
            'totalBlogs'      => Blog::count(),

            'lowStockProducts' => Product::where( 'stock', '<', 5 )->limit( 5 )->get(),
            'expiredCoupons'   => Coupon::where( 'expires_at', '<', now() )->get(),
            'unpaidInvoices'   => Invoice::where( 'status', '!=', Invoice::STATUS_PAID )->get(),

            'recentUsers'      => User::latest()->take( 5 )->get(),
            'recentInvoices'   => Invoice::latest()->take( 5 )->get(),
            'recentQuotations' => Quotation::latest()->take( 5 )->get(),
        ];

        return view( 'dashboard.index', $data );
    }

    // public function index() {
    //     return view( 'dashboard.index', [
    //         'userCount' => User::count(),
    //         'productCount' => Product::count(),
    //         'quotationCount' => Quotation::count(),
    //         'invoiceCount' => Invoice::count(),
    //         'latestUsers' => User::latest()->take( 5 )->get(),
    //         'latestProducts' => Product::latest()->take( 5 )->get(),
    // ] );
    // }
}
