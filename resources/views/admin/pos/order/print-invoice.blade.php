<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture – {{ $order_id }}</title>

    <style>
        /* ----------------------------------------------
           GLOBAL PAGE STYLE A4
        ------------------------------------------------*/
        @page {
            size: A4;
            margin: 20mm;
            /* marge imprimable */
        }

        body.landscape {
            transform: rotate(-90deg) translate(-100%);
            transform-origin: top left;
            width: 100vh;
            height: 100vw;
        }

        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: auto;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 0;
            padding: 0;
        }

        /* ----------------------------------------------
           HEADER STYLE
        ------------------------------------------------*/
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e5e5;
        }

        .logo img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 22px;
            font-weight: 700;
        }

        /* ----------------------------------------------
           TABLE STYLE
        ------------------------------------------------*/
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 14px;
        }


        th {
            background: #d5e2f7;
            /* gris clair premium */
            color: #333;
            /* texte foncé lisible */
            padding: 10px;
            font-weight: 600;
            border-bottom: 2px solid #E3E6EB;
        }


        td {
            border: 1px solid #ddd;
            padding: 8px 10px;
        }

        tr:nth-child(even) {
            background: #f7f9fc;
        }

        /* ----------------------------------------------
           TOTAL SECTION
        ------------------------------------------------*/
        .totals {
            margin-top: 25px;
            float: right;
            width: 45%;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background: #fafafa;
        }

        .totals table td {
            border: none !important;
            font-size: 15px;
            padding: 4px;
        }

        .totals .amount {
            font-weight: bold;
            text-align: right;
        }

        /* ----------------------------------------------
           SIGNATURE + QR + CACHE
        ------------------------------------------------*/
        .footer-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            border-top: 2px solid #555;
            padding-top: 10px;
            text-align: center;
        }

        .stamp img {
            width: 120px;
            opacity: 0.85;
        }

        .qrcode-box {
            width: 45%;
            text-align: right;
        }

        .qrcode-box img {
            width: 120px;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 6px;
        }
    </style>
</head>

<body class="{{ $orientation ?? 'portrait' }}"> <!-- portrait ou landscape -->

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            @php
                $logoPath = public_path('storage/uploads/logo/' . ($setting->logo ?? ''));
            @endphp
            <div class="logo">
                <img 
                src="{{ !empty($setting->logo) && file_exists($logoPath)
                    ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
                    : asset('front-template/assets/images/logo/logo.png') }}"
                >
            </div>

            <div class="header-title">FACTURE</div>
            <small>N° : <strong>#INV-{{ $order_id }}</strong></small><br>
            <small>Date : {{ now()->format('d/m/Y H:i') }}</small>
        </div>

        <!-- FROM - TO -->
        <table>
            <tr>
                <th>Émetteur</th>
                <th>Client</th>
            </tr>
            <tr>
                <td>
                    <strong>{{ $setting->app_name }}</strong><br>
                    Tél : {{ $setting->phone }}<br>
                    Email : {{ $setting->email }}<br>
                </td>
                <td>
                    <strong>{{ $customer?->name ?? 'xxx' }}</strong><br>
                    Tél : {{ $customer?->phone ?? 'xxx' }}<br>
                    Email : {{ $customer?->email ?? 'xxx' }}<br>
                </td>
            </tr>
        </table>

        <!-- PRODUCTS -->
        <table>
            <tr>
                <th>Code</th>
                <th>Produit</th>
                <th>Prix</th>
                <th>Qté</th>
                <th>Total</th>
                <th>TVA</th>
                <th>Total TTC</th>
            </tr>

            @php
                $total = 0;
                $tva = 0;
            @endphp

            @foreach ($orderProducts as $item)
                @php
                    $subtotal = $item->quantity * $item->unit_price;
                    $total += $subtotal;
                @endphp

                <tr align="center">
                    <td>{{ $item->product->code }}</td>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ number_format($item->unit_price, 0, ',', '.') }} {{ $setting->devise }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($subtotal, 0, ',', '.') }} {{ $setting->devise }}</td>
                    <td>0</td>
                    <td>{{ number_format($subtotal, 0, ',', '.') }} {{ $setting->devise }}</td>
                </tr>
            @endforeach
        </table>

        <!-- TOTALS -->
        <div class="totals">
            <table>
                <tr>
                    <td>Sous-total :</td>
                    <td class="amount">{{ number_format($total, 0, ',', '.') }} {{ $setting->devise }}</td>
                </tr>
                <tr>
                    <td>TVA :</td>
                    <td class="amount">{{ number_format($tva, 0, ',', '.') }} {{ $setting->devise }}</td>
                </tr>
                <tr>
                    <td><strong>Total à payer :</strong></td>
                    <td class="amount"><strong>{{ number_format($total + $tva, 0, ',', '.') }}
                            {{ $setting->devise }}</strong></td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <!-- FOOTER WITH SIGNATURE + STAMP + QR -->
        <div class="footer-section">

            <!-- SIGNATURE -->
            <div class="signature-box">
                <div>Signature</div>
                <br><br><br>
                <small>{{ $setting->app_name }}</small>
            </div>

            <!-- QR CODE + STAMP -->
            <div class="qrcode-box">
                <strong>Paiement par QR Code</strong><br>
                <img src="{{ $payment_qr ?? '' }}" alt="QR Code">

                <div class="stamp">
                    <img src="{{ $stamp_image ?? '' }}" alt="Cachet">
                </div>
            </div>

        </div>

    </div>

</body>

</html>
