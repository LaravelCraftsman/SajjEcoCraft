<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $categoryName }} - Product List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        h1,
        h2,
        h3 {
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 80px;
            max-height: 80px;
            object-fit: cover;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ $logoPath }}" alt="Sajj EcoCraft" style="width: 200px;height:auto;">
    </div>

    <!-- Category Name -->
    <div style="background: green; color: white; padding: 5px 10px; margin-bottom: 15px;">
        <strong style="text-transform: uppercase;">{{ $categoryName }}</strong>
    </div>

    <!-- Products Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Sr. No</th>
                <th style="width: 20%;">Item Image</th>
                <th style="width: 40%;">Particulars</th>
                <th style="width: 17%;">Size</th>
                <th style="width: 15%;">Price (₹)</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($products as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if (!empty($item->main_image))
                            <img src="{{ public_path(parse_url($item->main_image, PHP_URL_PATH)) }}"
                                alt="{{ $item->name }}">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->size ?? 'N/A' }}</td>
                    <td>₹{{ number_format($item->discounted_price ?? $item->selling_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        &copy; {{ date('Y') }} SajjEcoCraft. All rights reserved.
    </div>

</body>

</html>
