<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainPagesController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Auth routes (if needed globally, place outside admin prefix)
Auth::routes();

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Image upload routes
    Route::get('/upload-image', [ImageUploadController::class, 'create'])->name('image.upload.create');
    Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('image.upload.store');

    Route::get('/upload-form', function () {
        return view('tutorial.upload');
    })->name('upload.form');

    // Resources
    Route::resource('sliders', SliderController::class);

    Route::resource('staff', StaffController::class);
    Route::get('/staff/export', [StaffController::class, 'export'])->name('staff.export');

    Route::resource('branches', BranchController::class);

    Route::resource('blogs', BlogController::class);
    Route::post('blogs/upload', [BlogController::class, 'uploadImage'])->name('blogs.upload');

    Route::resource('faqs', FaqController::class);

    Route::get('banners', [BannerController::class, 'index'])->name('banners');
    Route::post('update_about_banner', [BannerController::class, 'updateAbout'])->name('update_about_banner');
    Route::post('update_blog_banner', [BannerController::class, 'updateBlog'])->name('update_blog_banner');

    Route::get('about_us', [AboutUsController::class, 'index'])->name('admin.about_us'); // renamed to avoid conflict
    Route::post('update_about_us', [AboutUsController::class, 'store'])->name('update_about_us');

    Route::resource('coupons', CouponController::class);

    Route::resource('contactRequests', ContactRequestController::class);

    Route::resource('site_settings', SiteSettingsController::class);

    Route::resource('customers', CustomerController::class);
    Route::get('/customers/export', [CustomerController::class, 'export'])->name('customers.export');

    Route::resource('vendors', VendorController::class);

    Route::resource('categories', CategoryController::class);
    Route::get('/categories/{id}/pdf', [CategoryController::class, 'downloadPdf'])->name('categories.pdf');

    // Product image handling routes
    Route::resource('products', ProductsController::class);
    Route::post('/products/upload-image', [ProductsController::class, 'uploadImage'])->name('products.upload-image');
    Route::post('/products/delete-image', [ProductsController::class, 'deleteImage'])->name('products.delete-image');
    Route::delete('/products/{product}/images', [ProductsController::class, 'removeImage'])->name('products.images.remove');
    Route::get('/barcode/download/{uniqueId}/{type}', [ProductsController::class, 'downloadBarcode'])->name('barcode.download');

    Route::resource('invoices', InvoiceController::class);
    Route::resource('quotations', QuotationController::class);

    // Profile routes grouped with middleware already applied
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

// Main Site Pages (public facing)
Route::controller(MainPagesController::class)->group(function () {
    Route::get('/', 'index')->name('main.index');
    Route::get('shop', 'shop')->name('shop');
    Route::get('shop/{slug}', 'shop_detail')->name('shop.details');
    Route::get('about_us', 'about_us')->name('about_us');
    Route::get('blogs', 'blogs')->name('blogs');
    Route::get('/blog/{slug}','blog_details')->name('blog.details');
    Route::get('contact_us','contact_us')->name('contact_us');
});
