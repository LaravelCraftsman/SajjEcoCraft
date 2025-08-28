<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class InvoiceController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $invoices = Invoice::with( 'customer' )->latest()->paginate( 15 );
        return view( 'invoices.index', compact( 'invoices' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        $customers = User::where( 'role', 'customer' )->get();
        $products = Product::all();
        return view( 'invoices.create', compact( 'customers', 'products' ) );
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
            'invoice_number' => [ 'required', 'string', 'unique:invoices,invoice_number' ],
            'invoice_date' => [ 'required', 'date' ],
            'status' => [ 'required', Rule::in( [ 'draft', 'sent', 'paid', 'cancelled' ] ) ],
            'notes' => [ 'nullable', 'string' ],
            'products' => [ 'required', 'array', 'min:1' ],
            'products.*.product_id' => [ 'required', 'exists:products,id' ],
            'products.*.quantity' => [ 'required', 'numeric', 'min:0.01' ],
            'products.*.rate' => [ 'required', 'numeric', 'min:0' ],
        ] );

        // Step 1: Create Invoice
        $invoice = new Invoice();
        $invoice->customer_id = $validated[ 'customer_id' ];
        $invoice->invoice_number = $validated[ 'invoice_number' ];
        $invoice->invoice_date = $validated[ 'invoice_date' ];
        $invoice->status = $validated[ 'status' ];
        $invoice->notes = $validated[ 'notes' ] ?? null;
        $invoice->total_amount = 0;
        // placeholder
        $invoice->save();

        $totalAmount = 0;

        // Step 2: Add Products one by one
        foreach ( $validated[ 'products' ] as $item ) {
            $amount = $item[ 'quantity' ] * $item[ 'rate' ];
            $product = Product::find( $item[ 'product_id' ] );

            $invoiceProduct = new InvoiceProduct();
            $invoiceProduct->invoice_id = $invoice->id;
            $invoiceProduct->product_id = $item[ 'product_id' ];
            $invoiceProduct->quantity = $item[ 'quantity' ];
            $invoiceProduct->rate = $item[ 'rate' ];
            $invoiceProduct->amount = $amount;
            $invoiceProduct->image = $product->main_image;
            $invoiceProduct->save();

            $totalAmount += $amount;
        }

        // Step 3: Update total_amount on invoice
        $invoice->total_amount = $totalAmount;
        $invoice->save();

        return redirect()->route( 'invoices.index' )->with( 'success', 'Invoice created successfully!' );

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    *Get PDF SHOW HERE
    */

    public function show( $id ) {
        // Existing code...
        $invoice = Invoice::with( [ 'customer', 'products.product' ] )->findOrFail( $id );
        $siteSettings = SiteSettings::findOrFail( 1 );

        // Calculate subtotal and GST same as in view ( better to move to helper, but for now do here )
        $subtotal = 0;
        $gstTotal = 0;
        foreach ( $invoice->products as $invProd ) {
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

        if ( $invoice->coupon_type === 'percentage' ) {
            $discountAmount = ( $originalAmount * $invoice->coupon_value ) / 100;
        } elseif ( $invoice->coupon_type === 'fixed' ) {
            $discountAmount = $invoice->coupon_value;
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

        $data = compact( 'invoice', 'logoPath', 'siteSettings', 'subtotal', 'gstTotal', 'originalAmount', 'discountAmount', 'finalAmount' );

        $html = View::make( 'pdf.invoice', $data )->render();

        $mpdf = new Mpdf( [
            'mode' => 'utf-8',
            'format' => 'A4',
        ] );
        $mpdf->showImageErrors = true;
        $mpdf->SetFont( 'dejavusans' );
        $mpdf->WriteHTML( $html );

        return response( $mpdf->Output( '', 'S' ), 200 )
        ->header( 'Content-Type', 'application/pdf' )
        ->header( 'Content-Disposition', 'inline; filename="invoice_' . $invoice->invoice_number . '.pdf"' );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        $invoice = Invoice::with( 'products' )->findOrFail( $id );
        $customers = User::where( 'role', 'customer' )->get();
        $products = Product::all();

        return view( 'invoices.edit', compact( 'invoice', 'customers', 'products' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $invoice = Invoice::findOrFail( $id );

        $validated = $request->validate( [
            'customer_id' => [ 'required', 'exists:users,id' ],
            'invoice_number' => [ 'required', 'string', Rule::unique( 'invoices', 'invoice_number' )->ignore( $invoice->id ) ],
            'invoice_date' => [ 'required', 'date' ],
            'status' => [ 'required', Rule::in( [ 'draft', 'sent', 'paid', 'cancelled' ] ) ],
            'notes' => [ 'nullable', 'string' ],
            'products' => [ 'required', 'array', 'min:1' ],
            'products.*.id' => [ 'nullable', 'exists:invoice_products,id' ],
            'products.*.product_id' => [ 'required', 'exists:products,id' ],
            'products.*.quantity' => [ 'required', 'numeric', 'min:0.01' ],
            'products.*.rate' => [ 'required', 'numeric', 'min:0' ],
        ] );

        // Step 1: Update invoice info
        $invoice->customer_id = $validated[ 'customer_id' ];
        $invoice->invoice_number = $validated[ 'invoice_number' ];
        $invoice->invoice_date = $validated[ 'invoice_date' ];
        $invoice->status = $validated[ 'status' ];
        $invoice->notes = $validated[ 'notes' ] ?? null;
        $invoice->save();

        // Step 2: Manage products manually

        $existingProductIds = $invoice->products()->pluck( 'id' )->toArray();
        $incomingProductIds = collect( $validated[ 'products' ] )->pluck( 'id' )->filter()->toArray();

        // Delete removed products
        $toDelete = array_diff( $existingProductIds, $incomingProductIds );
        if ( !empty( $toDelete ) ) {
            InvoiceProduct::destroy( $toDelete );
        }

        $totalAmount = 0;

        // Update existing or add new products
        foreach ( $validated[ 'products' ] as $item ) {
            $amount = $item[ 'quantity' ] * $item[ 'rate' ];
            $product = Product::find( $item[ 'product_id' ] );

            if ( !empty( $item[ 'id' ] ) ) {
                $invoiceProduct = InvoiceProduct::find( $item[ 'id' ] );
                if ( $invoiceProduct ) {
                    $invoiceProduct->product_id = $item[ 'product_id' ];
                    $invoiceProduct->quantity = $item[ 'quantity' ];
                    $invoiceProduct->rate = $item[ 'rate' ];
                    $invoiceProduct->amount = $amount;
                    $invoiceProduct->image = $product->main_image;
                    $invoiceProduct->save();
                }
            } else {
                $invoiceProduct = new InvoiceProduct();
                $invoiceProduct->invoice_id = $invoice->id;
                $invoiceProduct->product_id = $item[ 'product_id' ];
                $invoiceProduct->quantity = $item[ 'quantity' ];
                $invoiceProduct->rate = $item[ 'rate' ];
                $invoiceProduct->amount = $amount;
                $invoiceProduct->image = $product->main_image;
                $invoiceProduct->save();
            }

            $totalAmount += $amount;
        }

        $invoice->total_amount = $totalAmount;
        $invoice->save();

        return redirect()->route( 'invoices.index', $invoice )->with( 'success', 'Invoice updated successfully!' );

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $invoice = Invoice::findOrFail( $id );
        $invoice->delete();
        return redirect()->route( 'invoices.index' )->with( 'success', 'Invoice deleted successfully!' );
    }
}
