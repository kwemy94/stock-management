{{-- @php
    $setting = getCompanyInfo();
@endphp --}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ env('APP_NAME') }}</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .banner {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 35px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .banner h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.4rem;
        }

        .banner small {
            display: block;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .table {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        thead {
            background-color: #007bff;
            color: #fff;
        }

        th,
        td {
            vertical-align: middle !important;
            padding: 8px 12px;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f6fc;
        }

        img.barcode {
            width: 80px;
            height: 30px;
            object-fit: contain;
        }

        img.barcode {
            width: 150px;
            /* largeur imprimable */
            height: 50px;
            /* hauteur imprimable */
            object-fit: contain;
        }


        .footer {
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 50px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .table {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        {{-- 🔹 Logo de ton application (mettre le bon chemin vers public/images/logo.png) --}}
        {{-- <img src='{{ isset($setting->logo) ? asset("storage/images/logo/$setting->logo") : asset('front-template/assets/images/logo/logo.png') }}'
            alt="Logo"> --}}
    </div>

    <div class="banner">
        <h3>{{ env('APP_NAME') }} — {{ $title }}</h3>
        <small>Généré le {{ $date }}</small>
    </div>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom du produit</th>
                <th>Code-barres</th>
                <th>Date d’enregistrement</th>

                <th>#</th>
                <th>Nom du produit</th>
                <th>Code-barres</th>
                <th>Date d’enregistrement</th>
            </tr>
        </thead>

        <tbody>
            @php $index = 1; @endphp

            @foreach ($products->chunk(2) as $chunk)
                <tr>
                    {{-- 🔹 Produit 1 --}}
                    @php $p1 = $chunk[0]; @endphp
                    <td>{{ $index }}</td>
                    <td>{{ $p1->product_name }}</td>
                    <td style="text-align:center;">
                        @if (!empty($p1->barcode_base64))
                            <img class="barcode" src="data:image/png;base64, {{ $p1->barcode_base64 }}"
                                alt="Code-barres">
                            <br>
                            <span style="font-size:0.85rem; font-family:monospace;">
                                {{ $p1->code }}
                            </span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($p1->created_at)->format('d/m/Y H:i') }}</td>

                    {{-- 🔹 Produit 2 (ou vide si nombre impair) --}}
                    @if (isset($chunk[1]))
                        @php $p2 = $chunk[1]; @endphp
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p2->product_name }}</td>
                        <td style="text-align:center;">
                            @if (!empty($p2->barcode_base64))
                                <img class="barcode" src="data:image/png;base64, {{ $p2->barcode_base64 }}"
                                    alt="Code-barres">
                                <br>
                                <span style="font-size:0.85rem; font-family:monospace;">
                                    {{ $p2->code }}
                                </span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($p2->created_at)->format('d/m/Y H:i') }}</td>
                    @else
                        {{-- colonnes vides si pas de 2e produit --}}
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                @php $index += 2; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} {{ env('APP_NAME') }} — Rapport généré automatiquement
    </div>
</body>

</html>
