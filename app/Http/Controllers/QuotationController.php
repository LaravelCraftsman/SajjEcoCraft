<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\User;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\QuotationProduct;
use Illuminate\Support\Facades\View;

class QuotationController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $allQuotations = Quotation::with( 'customer' )->latest()->paginate( 15 );
        return view( 'quotations.index', compact( 'allQuotations' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        $customers = User::where( 'role', 'customer' )->get();
        $products = Product::all();
        return view( 'quotations.create', compact( 'customers', 'products' ) );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        $validated = $request->validate( [
            'customer_id' => [ 'required', 'exists:users,id' ],
            'quotation_number' => [ 'required', 'string', 'unique:quotations,quotation_number' ],
            'quotation_date' => [ 'required', 'date' ],
            'status' => [ 'required', Rule::in( [ 'draft', 'sent', 'paid', 'cancelled' ] ) ],
            'notes' => [ 'nullable', 'string' ],
            'products' => [ 'required', 'array', 'min:1' ],
            'products.*.product_id' => [ 'required', 'exists:products,id' ],
            'products.*.quantity' => [ 'required', 'numeric', 'min:0.01' ],
            'products.*.rate' => [ 'required', 'numeric', 'min:0' ],
        ] );

        // Step 1: Create quotation
        $quotation = new Quotation();
        $quotation->customer_id = $validated[ 'customer_id' ];
        $quotation->quotation_number = $validated[ 'quotation_number' ];
        $quotation->quotation_date = $validated[ 'quotation_date' ];
        $quotation->status = $validated[ 'status' ];
        $quotation->notes = $validated[ 'notes' ] ?? null;
        $quotation->total_amount = 0;
        // placeholder
        $quotation->save();

        $totalAmount = 0;

        // Step 2: Add Products one by one
        foreach ( $validated[ 'products' ] as $item ) {
            $amount = $item[ 'quantity' ] * $item[ 'rate' ];
            $product = Product::find( $item[ 'product_id' ] );

            $quotationProduct = new QuotationProduct();
            $quotationProduct->quotation_id = $quotation->id;
            $quotationProduct->product_id = $item[ 'product_id' ];
            $quotationProduct->quantity = $item[ 'quantity' ];
            $quotationProduct->rate = $item[ 'rate' ];
            $quotationProduct->amount = $amount;
            $quotationProduct->image = $product->main_image;
            $quotationProduct->save();

            $totalAmount += $amount;
        }

        // Step 3: Update total_amount on quotation
        $quotation->total_amount = $totalAmount;
        $quotation->save();

        return redirect()->route( 'quotations.index' )->with( 'success', 'Quotation created successfully!' );

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        // Existing code...
        $quotation = Quotation::with( [ 'customer', 'products.product' ] )->findOrFail( $id );
        $siteSettings = SiteSettings::findOrFail( 1 );

        // Calculate subtotal and GST same as in view ( better to move to helper, but for now do here )
        $subtotal = 0;
        $gstTotal = 0;
        foreach ( $quotation->products as $invProd ) {
            $product = $invProd->product;
            $quantity = ( float ) $invProd->quantity;

            $unit_rate = $product->purchase_price + $product->profit;
            $total_price = $unit_rate * $quantity;

            $hasDiscount = $product->discount > 0;
            $unit_offer = $unit_rate - $product->discount;
            $total_offer = $hasDiscount ? $unit_offer * $quantity : 0;

            $effective_price = $hasDiscount ? $total_offer : $total_price;

            $gst = $effective_price * 0.18;

            $subtotal += $effective_price;
            $gstTotal += $gst;
        }

        $originalAmount = $subtotal + $gstTotal;
        $discountAmount = 0;
        $finalAmount = $originalAmount;

        if ( $quotation->coupon_type === 'percentage' ) {
            $discountAmount = ( $originalAmount * $quotation->coupon_value ) / 100;
        } elseif ( $quotation->coupon_type === 'fixed' ) {
            $discountAmount = $quotation->coupon_value;
        }

        $discountAmount = min( $discountAmount, $originalAmount );
        $finalAmount = $originalAmount - $discountAmount;

        $logoUrl = $siteSettings->logo_dark_image;

        if ( filter_var( $logoUrl, FILTER_VALIDATE_URL ) ) {
            $logoPath = public_path( parse_url( $logoUrl, PHP_URL_PATH ) );
        } else {
            $logoPath = public_path( $logoUrl );
        }

        if ( !file_exists( $logoPath ) ) {
            $logoPath = public_path( 'default-logo.png' );
        }

        $data = compact( 'quotation', 'logoPath', 'siteSettings', 'subtotal', 'gstTotal', 'originalAmount', 'discountAmount', 'finalAmount' );

        $html = View::make( 'pdf.quotation', $data )->render();

        $mpdf = new Mpdf( [
            'mode' => 'utf-8',
            'format' => 'A4',
        ] );
        $mpdf->showImageErrors = true;
        $mpdf->SetFont( 'dejavusans' );
        $mpdf->WriteHTML( $html );

        return response( $mpdf->Output( '', 'S' ), 200 )
        ->header( 'Content-Type', 'application/pdf' )
        ->header( 'Content-Disposition', 'inline; filename="quotation_' . $quotation->quotation_number . '.pdf"' );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        $quotation = Quotation::with( 'products' )->findOrFail( $id );
        $customers = User::where( 'role', 'customer' )->get();
        $products = Product::all();

        return view( 'quotations.edit', compact( 'quotation', 'customers', 'products' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $quotation = Quotation::findOrFail( $id );

        $validated = $request->validate( [
            'customer_id' => [ 'required', 'exists:users,id' ],
            'quotation_number' => [ 'required', 'string', Rule::unique( 'quotations', 'quotation_number' )->ignore( $quotation->id ) ],
            'quotation_date' => [ 'required', 'date' ],
            'status' => [ 'required', Rule::in( [ 'draft', 'sent', 'paid', 'cancelled' ] ) ],
            'notes' => [ 'nullable', 'string' ],
            'products' => [ 'required', 'array', 'min:1' ],
            'products.*.id' => [ 'nullable', 'exists:quotation_products,id' ],
            'products.*.product_id' => [ 'required', 'exists:products,id' ],
            'products.*.quantity' => [ 'required', 'numeric', 'min:0.01' ],
            'products.*.rate' => [ 'required', 'numeric', 'min:0' ],
        ] );

        // Step 1: Update quotation info
        $quotation->customer_id = $validated[ 'customer_id' ];
        $quotation->quotation_number = $validated[ 'quotation_number' ];
        $quotation->quotation_date = $validated[ 'quotation_date' ];
        $quotation->status = $validated[ 'status' ];
        $quotation->notes = $validated[ 'notes' ] ?? null;
        $quotation->save();

        // Step 2: Manage products manually

        $existingProductIds = $quotation->products()->pluck( 'id' )->toArray();
        $incomingProductIds = collect( $validated[ 'products' ] )->pluck( 'id' )->filter()->toArray();

        // Delete removed products
        $toDelete = array_diff( $existingProductIds, $incomingProductIds );
        if ( !empty( $toDelete ) ) {
            QuotationProduct::destroy( $toDelete );
        }

        $totalAmount = 0;

        // Update existing or add new products
        foreach ( $validated[ 'products' ] as $item ) {
            $amount = $item[ 'quantity' ] * $item[ 'rate' ];
            $product = Product::find( $item[ 'product_id' ] );

            if ( !empty( $item[ 'id' ] ) ) {
                $quotationProduct = QuotationProduct::find( $item[ 'id' ] );
                if ( $quotationProduct ) {
                    $quotationProduct->product_id = $item[ 'product_id' ];
                    $quotationProduct->quantity = $item[ 'quantity' ];
                    $quotationProduct->rate = $item[ 'rate' ];
                    $quotationProduct->amount = $amount;
                    $quotationProduct->image = $product->main_image;
                    $quotationProduct->save();
                }
            } else {
                $quotationProduct = new QuotationProduct();
                $quotationProduct->quotation_id = $quotation->id;
                $quotationProduct->product_id = $item[ 'product_id' ];
                $quotationProduct->quantity = $item[ 'quantity' ];
                $quotationProduct->rate = $item[ 'rate' ];
                $quotationProduct->amount = $amount;
                $quotationProduct->image = $product->main_image;
                $quotationProduct->save();
            }

            $totalAmount += $amount;
        }

        $quotation->total_amount = $totalAmount;
        $quotation->save();

        return redirect()->route( 'quotations.index', $quotation )->with( 'success', 'Quotation updated successfully!' );

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $quotation = Quotation::findOrFail( $id );
        $quotation->delete();
        return redirect()->route( 'quotations.index' )->with( 'success', 'Quotation deleted successfully!' );
    }
}
