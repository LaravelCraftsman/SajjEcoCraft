<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ImageUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload-image', [ImageUploadController::class, 'create'])->name('image.upload.create');
Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('image.upload.store');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('sliders', SliderController::class);
Route::get('/upload-form', function () {
    return view('tutorial.upload');
});





Route::get('/staff/export', [StaffController::class, 'export'])->name('staff.export');

Route::resource('staff', StaffController::class);


Route::resource('branches', BranchController::class);

// web.php
Route::post('blogs/upload', [App\Http\Controllers\BlogController::class, 'uploadImage'])->name('blogs.upload');
Route::resource('blogs', BlogController::class);


Route::resource('faqs',FaqController::class);
    Route::get('banners', [BannerController::class, 'index'])->name('banners');
    Route::post('update_about_banner', [BannerController::class, 'updateAbout'])->name('update_about_banner');
    Route::post('update_blog_banner', [BannerController::class, 'updateBlog'])->name('update_blog_banner');

    Route::get('about_us', [AboutUsController::class, 'index'])->name('about_us');
    Route::post('update_about_us', [AboutUsController::class, 'store'])->name('update_about_us');
