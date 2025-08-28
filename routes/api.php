<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\ImageUploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/upload', [ImageUploadController::class, 'upload']);
Route::get('/vendor-prices/{id}', [ApiController::class, 'vendorPrices']);

Route::delete('/products/{product}/images', [ApiController::class, 'deleteImage']);
Route::post('/coupons/validate/invoice', [ApiController::class, 'validateCouponInvoices'])->name('coupons.validate.invoice');
Route::post('/coupons/validate/quotation', [ApiController::class, 'validateCouponQuotations'])->name('coupons.validate.quotation');

Route::post('/contact-request', [ApiController::class, 'contactRequest'])->name('storeContactRequest');
