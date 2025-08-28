<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>quotation - {{ $quotation->quotation_number }}</title>
    <style>
        .quotation-summary {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            font-size: 13px;
        }

        .quotation-summary td,
        .quotation-summary th {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: right;
        }

        .quotation-summary .label {
            text-align: left;
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .quotation-summary .grand-total {
            font-size: 16px;
            font-weight: bold;
        }

        .amount-in-words {
            margin-top: 10px;
            font-style: italic;
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .quotation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .quotation-table th,
        .quotation-table td {
            border: 1px solid #bbb;
            padding: 8px 10px;
            text-align: center;
            vertical-align: middle;
        }

        .quotation-table th {
            background-color: #f2f2f2;
            color: #333;
        }

        .quotation-table td img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .totals {
            margin-top: 30px;
            font-size: 13px;
        }

        .totals p,
        .totals h3 {
            text-align: right;
            margin-right: 20px;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        .header,
        .footer {
            text-align: center;
        }

        img {
            max-width: 70px;
            max-height: 70px;
            object-fit: cover;
        }

        .totals {
            margin-top: 20px;
        }

        .logo-img {
            max-width: none !important;
            max-height: none !important;
            width: 300px !important;
            height: auto !important;
            object-fit: contain !important;
        }
    </style>
</head>

<body>

    <table style="width: 100%; height: auto; table-layout: fixed; border-collapse: collapse;">
        <thead>
            <tr>
                <!-- First Column: Text Left-Aligned -->
                <th style="width: 30%; padding: 10px; vertical-align: middle; text-align: left; border: none;">
                    <h4>Sajj Decore</h4>
                    <p>
                        Ahmedabad <br />
                        State: Gujarat <br />
                        Mobile No: 7698311711
                    </p>
                </th>

                <!-- Second Column: Image Centered (Max Size) -->
                <th style="width: 40%; padding: 10px; vertical-align: middle; text-align: center; border: none;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img class="logo-img" src="{{ $logoPath }}" alt="Sajj EcoCraft"
                            style="width: 120px; max-height: auto; object-fit: contain;">
                    </div>
                </th>

                <!-- Third Column: Text Right-Aligned -->
                <th style="width: 30%; padding: 10px; vertical-align: middle; text-align: right; border: none;">
                    <p>
                        Date:{{ $quotation->quotation_date->format('d-M-Y') }}<br />
                        Order No: {{ $quotation->order_id ?? 'N/A' }} <br>
                        Name: {{ $quotation->customer->name ?? 'N/A' }}<br>
                        Quotation: {{ $quotation->quotation_number }}

                    </p>
                </th>
            </tr>
        </thead>
    </table>


    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td
                style="text-align:center; width: 20%; background-color: black; border: 1px solid black; color:white; padding:10px;">
                BILL OF SUPPLY
            </td>
        </tr>
    </table>



    {{-- quotation Items Table --}}
    <table class="quotation-table">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Particulars</th>
                <th>Image</th>
                <th>Unit Rate (Rs.)</th>
                <th>QTY</th>
                <th>Total Price (Rs.)</th>
                <th>Offer Price (Rs.)</th>
                <th>GST (18%)</th>
                <th>Total Amount (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subtotal = 0;
                $gstTotal = 0;
            @endphp

            @foreach ($quotation->products as $invProd)
                @php
                    $product = $invProd->product;
                    $quantity = (float) $invProd->quantity;

                    $unit_rate = $product->purchase_price + $product->profit;
                    $total_price = $unit_rate * $quantity;

                    $hasDiscount = $product->discount > 0;
                    $unit_offer = $unit_rate - $product->discount;
                    $total_offer = $hasDiscount ? $unit_offer * $quantity : 0;

                    $effective_price = $hasDiscount ? $total_offer : $total_price;

                    $gst = $effective_price * 0.18;
                    $totalAmount = $effective_price + $gst;

                    $subtotal += $effective_price;
                    $gstTotal += $gst;

                    $imagePath = public_path(parse_url($invProd->image, PHP_URL_PATH));
                    $imageExists = file_exists($imagePath);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $product->name ?? 'N/A' }}</td>
                    <td>
                        @if ($imageExists)
                            <img src="{{ $imagePath }}" alt="Product Image">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ number_format($unit_rate, 2) }}</td>
                    <td>{{ $quantity }}</td>
                    <td>{{ number_format($total_price, 2) }}</td>
                    <td>
                        {{ $hasDiscount ? number_format($total_offer, 2) : '-' }}
                    </td>
                    <td>{{ number_format($gst, 2) }}</td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="quotation-summary">
        <tr>
            <td class="label">Subtotal (without GST):</td>
            <td>Rs. {{ number_format($subtotal, 2) }}</td>
        </tr>
        <tr>
            <td class="label">GST (18%):</td>
            <td>Rs. {{ number_format($gstTotal, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td class="label">Grand Total:</td>
            <td>Rs. {{ number_format($originalAmount, 2) }}</td>
        </tr>

        @if ($quotation->coupon)
            <tr>
                <td class="label">Discount Amount:</td>
                <td>Rs. {{ number_format($discountAmount, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td class="label">Final Amount:</td>
                <td><strong>Rs. {{ number_format($finalAmount, 2) }}</strong></td>
            </tr>
        @endif

        <tr class="grand-total">
            <td class="label">Rupees in words:</td>
            <td>{{ \App\Helpers\NumberHelper::toWords($finalAmount) }}</td>
        </tr>
    </table>


    <br>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="text-align:center; background-color: black; border: 1px solid black; color:white; padding:10px;">
                BANK DETAILS
            </td>
        </tr>
    </table>
    <br />

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <td style="font-size:12px; text-align:center; background-color: lightgray; border: 1px solid black;">
                    HOLDER
                </td>
                <td style="font-size:12px; text-align:center; background-color: lightgray; border: 1px solid black;">
                    BANK NAME
                </td>
                <td style="font-size:12px; text-align:center; background-color: lightgray; border: 1px solid black;">
                    ACCOUNT NUMBER
                </td>
                <td style="font-size:12px; text-align:center; background-color: lightgray; border: 1px solid black;">
                    IFSC CODE
                </td>
                <td style="font-size:12px; text-align:center; background-color: lightgray; border: 1px solid black;">
                    GSTIN/UIN
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size:12px; text-align:center; background-color: white; border: 1px solid black;">
                    {{ $siteSettings->account_holder_name ?? 'N/A' }}
                </td>
                <td style="font-size:12px; text-align:center; background-color: white; border: 1px solid black;">
                    {{ $siteSettings->bank_name ?? 'N/A' }}
                </td>
                <td style="font-size:12px; text-align:center; background-color: white; border: 1px solid black;">
                    {{ $siteSettings->account_number ?? 'N/A' }}
                </td>
                <td style="font-size:12px; text-align:center; background-color: white; border: 1px solid black;">
                    {{ $siteSettings->ifsc_code ?? 'N/A' }}
                </td>
                <td style="font-size:12px; text-align:center; background-color: white; border: 1px solid black;">
                    {{ $siteSettings->gst ?? 'N/A' }}
                </td>
            </tr>
        </tbody>
    </table>
    <br /><br />

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td
                style="font-size:12px; text-align:left; background-color: white; border: 1px solid black; font-weight: bold; padding:10px;">
                Payment Condition :-<br /><br />
                100 % Advance with signed quotation.<br /><br />
                www.sajjecocraft.com<br /><br />
                Rajkot: Akshar Complex Nr.Jay Ganesh Showroom, 150 ft. Ring Road, Rajkot360005<br /><br />
                Ahmedabad: Gopal Estate, Nr Sanatan Cross Road, Changodar Road, Ahmedabad382210<br /><br />
            </td>

            <td
                style="font-size:12px; text-align:center; background-color: white; border: 1px solid black; padding:10px;">
                <b>Regards,</b><br /><br />
                <b></b><br /><br />
                Authorized Signature<br /><br />
            </td>
        </tr>
    </table>
</body>

</html>
