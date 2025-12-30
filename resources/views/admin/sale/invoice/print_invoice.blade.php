<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Facture - {{ $setting->app_name ?? 'Street Smart' }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #1f1f1f;
        }

        /* A4 layout */
        .page {
            width: 100%;
            padding: 25px 40px;
        }

        /* Header */
        .header {
            width: 100%;
            text-align: left;
            border-bottom: 3px solid #0099ff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .company-info {
            margin-top: 8px;
            font-size: 12px;
            color: #444;
            line-height: 1.5;
        }

        h1 {
            text-align: right;
            margin: -70px 0 0 0;
            color: #0099ff;
            letter-spacing: 1px;
            font-size: 30px;
        }

        .section-title {
            font-weight: bold;
            font-size: 15px;
            color: #0099ff;
            margin-top: 25px;
            margin-bottom: 10px;
            border-left: 4px solid #0099ff;
            padding-left: 8px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #eaf6ff;
            font-weight: bold;
            padding: 7px;
            border: 1px solid #cbddee;
            font-size: 12px;
        }

        table td {
            padding: 7px;
            border: 1px solid #d5d5d5;
            font-size: 12px;
        }

        /* Totals */
        .total-box {
            width: 280px;
            float: right;
            margin-top: 15px;
            border: 1px solid #bcd6eb;
            padding: 10px;
            background: #f7fbff;
            border-radius: 5px;
        }

        .total-box table td {
            border: none;
            padding: 4px 0;
            font-size: 13px;
        }

        .total-right {
            text-align: right;
        }

        .strong {
            font-weight: bold;
        }

        /* QR CODE container */
        .qr-section {
            margin-top: 40px;
            text-align: left;
            border-top: 2px dashed #ddd;
            padding-top: 20px;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            color: white;
            font-size: 11px;
        }

        .bg-danger {
            background: #dc3545;
        }

        .bg-primary {
            background: #0d6efd;
        }

        .bg-warning {
            background: #ffc107;
            color: #000;
        }

        .bg-success {
            background: #28a745;
        }
    </style>
</head>

<body>

    <div class="page">

        <!-- HEADER -->
        <div class="header">
            @php
                $logoPath = public_path('storage/uploads/logo/' . ($setting->logo ?? ''));
            @endphp
            <img class="logo"
                src="{{ !empty($setting->logo) && file_exists($logoPath)
                    ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
                    : asset('front-template/assets/images/logo/logo.png') }}">

            <h1>FACTURE</h1>

            <div class="company-info">
                <strong style="font-size: 15px;">
                    {{ $setting->app_name ?? 'Street Smart' }}
                </strong><br>
                {{ $setting->address ?? 'Douala, Cameroun' }} <br>
                Tél : {{ $setting->phone ?? '+237 672 517 118' }} <br>
                Email : {{ $setting->email ?? 'infos@techbriva.com' }} <br>
            </div>
        </div>

        <!-- INFO FACTURE -->
        <div class="section-title">Informations facture</div>

        <table>
            <tr>
                <td width="50%">
                    <strong>Facture N° :</strong> {{ $invoice->invoice_number }} <br>
                    <strong>Date impression :</strong> {{ date('d/m/Y H:i') }} <br>
                    <strong>Statut :</strong>
                    @if ($invoice->status)
                        <span
                            class="badge 
                        {{ $invoice->status == 'draft' ? 'bg-danger' : '' }}
                        {{ $invoice->status == 'confirmed' ? 'bg-primary' : '' }}
                        {{ $invoice->status == 'proformat' ? 'bg-warning' : '' }}
                        {{ $invoice->status == 'Payé' ? 'bg-success' : '' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    @endif
                </td>

                <td width="50%">
                    <strong>Client :</strong> {{ $invoice->customer->name ?? '---' }} <br>
                    <strong>Tél :</strong> {{ $invoice->customer->phone ?? '---' }} <br>
                    <strong>Email :</strong> {{ $invoice->customer->email ?? '---' }} <br>
                </td>
            </tr>
        </table>


        <!-- PRODUITS -->
        <div class="section-title">Détails des produits</div>

        <table>
            <tr>
                <th>Code</th>
                <th>Produit</th>
                <th>Qté</th>
                <th>PU</th>
                <th>Remise</th>
                <th>Taxe</th>
                <th>Total HT</th>
                <th>Total TTC</th>
            </tr>

            @php
                $totalHT = 0;
                $totalTTC = 0;
                $totalTax = 0;
            @endphp

            @foreach ($invoice->invoiceLines as $line)
                @php
                    $ht = $line->quantity * $line->unit_price * (1 - $line->remise / 100);
                    $ttc = $ht + $line->taxe;

                    $totalHT += $ht;
                    $totalTTC += $ttc;
                    $totalTax += $line->taxe;
                @endphp

                <tr align="center">
                    <td>{{ $line->product->code }}</td>
                    <td>{{ $line->product->product_name }}</td>
                    <td>{{ $line->quantity }}</td>
                    <td>{{ number_format($line->unit_price, 0, ',', ' ') }}</td>
                    <td>{{ $line->remise }}%</td>
                    <td>{{ number_format($line->taxe, 0, ',', ' ') }}</td>
                    <td>{{ number_format($ht, 0, ',', ' ') }} {{ $setting->devise }}</td>
                    <td>{{ number_format($ttc, 0, ',', ' ') }} {{ $setting->devise }}</td>
                </tr>
            @endforeach

        </table>


        <!-- TOTALS -->
        <div class="total-box">
            <table width="100%">
                <tr>
                    <td>Total HT :</td>
                    <td class="total-right strong">{{ number_format($totalHT, 0, ',', ' ') }} {{ $setting->devise }}
                    </td>
                </tr>
                <tr>
                    <td>Taxe :</td>
                    <td class="total-right strong">{{ number_format($totalTax, 0, ',', ' ') }} {{ $setting->devise }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Total TTC :</strong></td>
                    <td class="total-right strong" style="font-size: 15px; color:#0099ff;">
                        {{ number_format($totalTTC, 0, ',', ' ') }} {{ $setting->devise }}
                    </td>
                </tr>
            </table>
        </div>


        <!-- QR CODE SECTION -->
        <div class="qr-section">
            <strong>QR Code facture :</strong><br>

            {{-- QR Code basé sur numéro + montant --}}
            {{-- <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(120)->generate('FACTURE:' . $invoice->invoice_number . ' | MONTANT:' . $totalTTC)) }}"
                alt="QR Code"> --}}
            {!! $qrCode !!}
        </div>

        <div class="footer">
            Merci pour votre confiance – {{ $setting->app_name ?? 'Street Smart' }}
        </div>
    </div>

</body>

</html>
