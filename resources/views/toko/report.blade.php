<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Shop - {{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/toko/toko.js'])
    <!-- Alpine JS -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            padding: 20px;
            background: #f9fafb;
        }

        h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f3f4f6;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .total-sales {
            text-align: right;
        }

        /* Style khusus saat print */
        @media print {
            body {
                background: #fff !important;
                padding: 10px;
                font-size: 12px;
            }

            table {
                font-size: 12px;
            }

            th {
                background: #e5e7eb !important;
                /* Warna abu tipis */
                -webkit-print-color-adjust: exact;
                /* Biar warna ikut ke print */
            }

            tr:nth-child(even) {
                background: #fff !important;
                /* Hilangkan striping */
            }

            h1 {
                font-size: 18px;
                margin-bottom: 15px;
            }

            /* Hilangkan margin print bawaan browser */
            @page {
                margin: 10mm;
            }
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>

    <table>
        <thead>
            <tr>
                @foreach ($header as $head)
                <th>{{ $head }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($body as $row)
            <tr>
                @if ($title === 'Laporan Stok Produk')
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['stocks'] }}</td>
                <td>{{ $row['type'] }}</td>
                @else
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['total_qty'] }}</td>
                <td class="total-sales">{{ number_format($row['total_sales'], 0, ',', '.') }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Otomatis buka print dialog saat halaman sudah diload
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>
