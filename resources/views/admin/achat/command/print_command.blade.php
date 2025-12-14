<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture {{ $command->reference }}</title>

    <style>
        @page {
            size: A4;
            margin: 18mm;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #222;
        }

        /* ===== HEADER ===== */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 10px;
        }

        .header-left,
        .header-center,
        .header-right {
            display: table-cell;
            vertical-align: middle;
        }

        .header-left {
            width: 25%;
        }

        .header-center {
            width: 35%;
            text-align: center;
        }

        .header-right {
            width: 40%;
            text-align: right;
            font-size: 11px;
        }

        .logo {
            max-height: 70px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 2px;
            color: #1a73e8;
        }

        /* ===== TITRES ===== */
        h2 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #1a73e8;
        }

        .reference {
            text-align: center;
            font-size: 13px;
            margin-bottom: 20px;
        }

        /* ===== SECTIONS ===== */
        .section {
            margin-bottom: 20px;
        }

        /* ===== TABLES ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #444;
            padding: 6px 8px;
        }

        table th {
            background-color: #f0f3f7;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        /* ===== BADGES ===== */
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            color: #fff;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-primary {
            background-color: #007bff;
        }

        /* ===== TOTAL ===== */
        .total {
            font-size: 14px;
            font-weight: bold;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 40px;
            display: table;
            width: 100%;
        }

        .signature {
            display: table-cell;
            width: 50%;
            text-align: center;
        }

        .signature .line {
            margin: 60px auto 5px;
            width: 80%;
            border-top: 1px solid #000;
        }

        .signature span {
            font-size: 11px;
        }
    </style>
</head>

<body>

    <!-- ===== HEADER ===== -->
    <div class="header">
        <div class="header-left">
            <img class="logo"
                src="{{ isset($setting->logo)
                    ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/images/logo/' . $setting->logo)))
                    : 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('front-template/assets/images/logo/logo.png'))) }}">
        </div>

        <div class="header-center">
            <h1>COMMANDE</h1>
        </div>

        <div class="header-right">
            <strong style="font-size: 14px;">
                {{ $setting->app_name ?? 'Street Smart' }}
            </strong><br>
            {{ $setting->address ?? 'Douala, Cameroun' }}<br>
            Tél : {{ $setting->phone ?? '+237 672 517 118' }}<br>
            Email : {{ $setting->email ?? 'infos@techbriva.com' }}
        </div>
    </div>

    <!-- Référence -->
    <div class="reference">
        <strong>Référence :</strong> {{ $command->reference }}
        @if ($command->status == 'validated')
                        <span class="badge badge-success">Validée</span>
                    @elseif ($command->status == 'draft')
                        <span class="badge badge-danger">Brouillon</span>
                    @else
                        <span class="badge badge-primary">Confirmée</span>
                    @endif
    </div>

    <!-- ===== FOURNISSEUR ===== -->
    <div class="section">
        <h2>Fournisseur</h2>
        <table>
            <tr>
                <th style="width: 30%">Nom</th>
                <td>{{ $command->supplier->name }}</td>
            </tr>
            <tr>
                <th>Téléphone</th>
                <td>{{ $command->supplier->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $command->supplier->email ?? '—' }}</td>
            </tr>
        </table>
    </div>

    <!-- ===== INFOS COMMANDE ===== -->
    <div class="section">
        <h2>Informations de la commande</h2>
        <table>
            <tr>
                <th style="width: 30%">Date</th>
                <td>{{ $command->date_command }}</td>
            </tr>
            <tr>
                <th>Mode de paiement</th>
                <td>{{ $command->paymentMode->name ?? '—' }}</td>
            </tr>
            {{-- <tr>
                <th>Statut</th>
                <td>
                    @if ($command->status == 'validated')
                        <span class="badge badge-success">Validée</span>
                    @elseif ($command->status == 'draft')
                        <span class="badge badge-danger">Brouillon</span>
                    @else
                        <span class="badge badge-primary">Confirmée</span>
                    @endif
                </td>
            </tr> --}}
            <tr>
                <th>Montant total</th>
                <td class="total">
                    {{ number_format($command->amount, 2, ',', ' ') }} FCFA
                </td>
            </tr>
        </table>
    </div>

    <!-- ===== ARTICLES ===== -->
    <div class="section">
        <h2>Détails des articles</h2>
        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    {{-- <th>Description</th> --}}
                    <th>Qté</th>
                    <th>Unité</th>
                    <th>P.U</th>
                    <th>Remise %</th>
                    <th>HT</th>
                    <th>Taxe</th>
                    <th>TTC</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($command->purchaseOrderLines as $line)
                    @php
                        $montantHT = $line->quantity * $line->unit_price * (1 - $line->remise / 100);
                        $taxe = $montantHT * ($line->taxe / 100);
                        $ttc = $montantHT + $taxe;
                    @endphp
                    <tr>
                        <td>{{ $line->product->product_name }}</td>
                        {{-- <td>{{ $line->product->description ?? '' }}</td> --}}
                        <td class="text-right">{{ $line->quantity }}</td>
                        <td>{{ $line->product->unit_measure->name ?? '—' }}</td>
                        <td class="text-right">{{ number_format($line->unit_price, 0, ',', ' ') }}</td>
                        <td class="text-right">{{ $line->remise }}</td>
                        <td class="text-right">{{ number_format($montantHT, 0, ',', ' ') }}</td>
                        <td class="text-right">{{ number_format($taxe, 0, ',', ' ') }}</td>
                        <td class="text-right">{{ number_format($ttc, 0, ',', ' ') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ===== SIGNATURES ===== -->
    <div class="footer">
        <div class="signature">
            <div class="line"></div>
            <span>Responsable</span>
        </div>
        <div class="signature">
            <div class="line"></div>
            <span>Fournisseur</span>
        </div>
    </div>

</body>
</html>
