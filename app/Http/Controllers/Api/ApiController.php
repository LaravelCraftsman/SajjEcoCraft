<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use App\Models\Vendor;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Models\ContactRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller {
    public function vendorPrices( $id ) {
        $vendor = Vendor::find( $id );

        if ( !$vendor ) {
            return response()->json( [
                'success' => false,
                'message' => 'Vendor not found.',
            ], 404 );
        }

        return response()->json( [
            'success' => true,
            'data' => [
                'parking_charges' => $vendor->parking_charges ?? 0,
                'operational_charges' => $vendor->operational_charges ?? 0,
                'transport' => $vendor->transport ?? 0,
                'dead_stock' => $vendor->dead_stock ?? 0,
                'branding' => $vendor->branding ?? 0,
                'damage_and_shrinkege' => $vendor->damage_and_shrinkege ?? 0, // consider renaming
                'profit' => $vendor->profit ?? 0,
                'total_charges' => $vendor->total_charges, // from accessor
            ]
        ] );
    }

    public function deleteImage( Request $request, Product $product ) {
        $request->validate( [
            'image_url' => 'required|url',
        ] );

        $imageUrl = $request->input( 'image_url' );

        // Extract the relative path from the URL
        // Assuming the URL contains '/storage/' and your files are stored in 'public'
        $parsedUrl = parse_url( $imageUrl, PHP_URL_PATH );
        // e.g. /storage/products/image.jpg

        if ( !$parsedUrl ) {
            return response()->json( [ 'error' => 'Invalid image URL' ], 400 );
        }

        // Remove '/storage/' from the start to get relative path in storage/app/public
        $relativePath = ltrim( str_replace( '/storage/', '', $parsedUrl ), '/' );

        // Check if image exists in product images array
        $images = $product->images;
        if ( !in_array( $imageUrl, $images ) ) {
            return response()->json( [ 'error' => 'Image not found in product' ], 404 );
        }

        // Remove the image URL from the images array
        $updatedImages = array_filter( $images, fn( $img ) => $img !== $imageUrl );
        $product->images = array_values( $updatedImages );
        // reindex array

        // If the deleted image is the main_image, unset main_image
        if ( $product->main_image === $imageUrl ) {
            $product->main_image = null;
        }

        // Save the updated product
        $product->save();

        // Delete the image file from storage ( public disk )
        if ( Storage::disk( 'public' )->exists( $relativePath ) ) {
            Storage::disk( 'public' )->delete( $relativePath );
        }

        return response()->json( [
            'message' => 'Image deleted successfully',
            'images' => $product->images,
        ] );
    }

    public function validateCouponInvoices( Request $request ) {
        $request->validate( [
            'coupon_code' => 'required|string',
            'invoice_id'  => 'required|integer|exists:invoices,id',
        ] );

        $coupon = Coupon::where( 'code', $request->coupon_code )->first();

        if ( !$coupon ) {
            return response()->json( [ 'valid' => false, 'message' => 'Coupon code does not exist.' ] );
        }

        if ( !$coupon->is_active ) {
            return response()->json( [ 'valid' => false, 'message' => 'This coupon is inactive.' ] );
        }

        if ( $coupon->expires_at && $coupon->expires_at->isPast() ) {
            return response()->json( [ 'valid' => false, 'message' => 'This coupon has expired.' ] );
        }

        if ( $coupon->usage_limit !== null && $coupon->times_used >= $coupon->usage_limit ) {
            return response()->json( [ 'valid' => false, 'message' => 'This coupon usage limit has been reached.' ] );
        }

        $invoice = Invoice::find( $request->invoice_id );

        if ( !$invoice ) {
            return response()->json( [ 'valid' => false, 'message' => 'Invoice not found.' ] );
        }

        // Calculate the discount amount
        $originalAmount = $invoice->total_amount;
        $discountAmount = 0;

        if ( $coupon->type === 'percentage' ) {
            $discountAmount = ( $originalAmount * $coupon->discount ) / 100;
        } elseif ( $coupon->type === 'fixed' ) {
            $discountAmount = min( $coupon->discount, $originalAmount );
            // prevent negative totals
        }

        // Update the invoice with coupon details
        $invoice->coupon_id = $coupon->id;
        $invoice->coupon_type = $coupon->type;
        // Make sure this is either 'fixed' or 'percentage'
        $invoice->coupon_value =  $coupon->discount;
        // $invoice->total_amount = max( $originalAmount - $discountAmount, 0 );
        $invoice->save();

        // Increment coupon usage
        $coupon->increment( 'times_used' );
        $discount_value = $coupon->discount;
        return response()->json( [
            'valid' => true,
            'message' => 'Coupon applied successfully.',
            'discount_type' => $coupon->type,
            'discount_value' => $discount_value,
            'final_total' => $invoice->total_amount,
        ] );
    }

    public function validateCouponQuotations( Request $request ) {
        // dd( $request );
        $request->validate( [
            'coupon_code' => 'required|string',
            'quotations_id'  => 'required|integer|exists:quotations,id',
        ] );

        $coupon = Coupon::where( 'code', $request->coupon_code )->first();

        if ( !$coupon ) {
            return response()->json( [ 'valid' => false, 'message' => 'Coupon code does not exist.' ] );
        }

        if ( !$coupon->is_active ) {
            return response()->json( [ 'valid' => false, 'message' => 'This coupon is inactive.' ] );
        }

        if ( $coupon->expires_at && $coupon->expires_at->isPast() ) {
            return response()->json( [ 'valid' => false, 'message' => 'This coupon has expired.' ] );
        }

        if ( $coupon->usage_limit !== null && $coupon->times_used >= $coupon->usage_limit ) {
            return response()->json( [ 'valid' => false, 'message' => 'This coupon usage limit has been reached.' ] );
        }

        $quotation = Quotation::find( $request->quotations_id );

        if ( !$quotation ) {
            return response()->json( [ 'valid' => false, 'message' => 'quotation not found.' ] );
        }

        // Calculate the discount amount
        $originalAmount = $quotation->total_amount;
        $discountAmount = 0;

        if ( $coupon->type === 'percentage' ) {
            $discountAmount = ( $originalAmount * $coupon->discount ) / 100;
        } elseif ( $coupon->type === 'fixed' ) {
            $discountAmount = min( $coupon->discount, $originalAmount );
            // prevent negative totals
        }

        // Update the quotation with coupon details
        $quotation->coupon_id = $coupon->id;
        $quotation->coupon_type = $coupon->type;
        // Make sure this is either 'fixed' or 'percentage'
        $quotation->coupon_value =  $coupon->discount;
        // $quotation->total_amount = max( $originalAmount - $discountAmount, 0 );
        $quotation->save();

        // Increment coupon usage
        $coupon->increment( 'times_used' );
        $discount_value = $coupon->discount;
        return response()->json( [
            'valid' => true,
            'message' => 'Coupon applied successfully.',
            'discount_type' => $coupon->type,
            'discount_value' => $discount_value,
            'final_total' => $quotation->total_amount,
        ] );
    }

    public function contactRequest( Request $request ) {
        // Validate input
        $validator = Validator::make( $request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422 );
        }

        // Create ContactRequest
        $contactRequest = ContactRequest::create( $request->only( 'name', 'email', 'phone', 'message' ) );

        return response()->json( [
            'success' => true,
            'message' => 'Contact request submitted successfully.',
            'data'    => $contactRequest,
        ], 201 );
    }

}