<!DOCTYPE html>
<html>

<head>
    <title>Street Smart | invoice</title>
    <link rel="stylesheet"
        href="{{ asset('dashboard-template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }


    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .logo {
        margin-bottom: 5%;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }
</style>

<body>
    @php
        $setting = getCompanyInfo();
    @endphp
    <div class="logo">
        <img src="{{ isset($setting->logo) ? 'data:image/png;base64,' . base64_encode(file_get_contents('storage/images/logo/' . $setting->logo)) : 'data:image/png;base64,' . base64_encode(file_get_contents('front-template/assets/images/logo/logo.png')) }}"
            width="50px" height="50px" alt="logo">
    </div>
    {{-- <div class="head-title">
        <h1 class="text-center m-0 p-0">Invoice</h1>
    </div> --}}
    <div class="add-detail mt-10">
        {{-- @dd($orders): --}}
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">N° facture - <span class="gray-color">#{{ $invoice->invoice_number }}
                </span></p>
            {{-- <p class="m-0 pt-5 text-bold w-100">Order Id - <span class="gray-color">R00{{ $order_id }}I</span></p> --}}
            <p class="m-0 pt-5 text-bold w-100">Print Date - <span class="gray-color">{{ date('d-M-Y H:m:s') }}</span>
            </p>
        </div>


        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">
                    @switch($invoice->status)
                        @case('draft')
                            <span class="badge bg-danger">{{ $invoice->status }}</span>
                        @break

                        @case('confirmed')
                            <span class="badge bg-primary">{{ $invoice->status }}</span>
                        @break

                        @case('proformat')
                            <span class="badge bg-warning">{{ $invoice->status }}</span>
                        @break

                        @case('Payé')
                            <span class="badge bg-success">{{ $invoice->status }}</span>
                        @break

                        @default
                    @endswitch
                    From
                </th>
                <th class="w-50">To</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p>Ets : <strong>{{ isset($setting) ? $setting->app_name : 'Street Smart' }} </strong></p>
                        <p>Tél : <strong>{{ isset($setting) ? $setting->phone : '+237 672517118' }} </strong></p>
                        <p>Email : <strong>{{ isset($setting) ? $setting->email : 'infos@techbriva.com' }} </strong>
                        </p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <p>Nom : <strong>{{ isset($invoice->customer) ? $invoice->customer->name : 'xxx' }} </strong></p>
                        <p>Tél : <strong>{{ isset($invoice->customer) ? $invoice->customer->phone : 'xxx' }} </strong></p>
                        <p>Email : <strong>{{ isset($invoice->customer) ? $invoice->customer->email : 'xxx' }} </strong></p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">Code</th>
                <th class="w-50">Produit</th>
                <th class="w-50">Qté</th>
                <th class="w-50">Price</th>
                <th class="w-50">Remise</th>
                <th class="w-50">Taxe</th>
                <th class="w-50">Total HT</th>
                <th class="w-50">Total TTC</th>
            </tr>
            @php
                $totalHT = 0;
                $totalTTC = 0;
                $totalTax = 0;
            @endphp
            @foreach  ($invoice->invoiceLines as $line)
                <tr align="center">
                    @php
                        $total1 = $line->quantity * $line->unit_price * (1-$line->remise/100);
                        $total2 = $line->quantity * $line->unit_price * (1-$line->remise/100) + $line->taxe;
                        $totalHT += $total1;
                        $totalTTC += $total2;
                        
                        $totalTax += $line->taxe;
                    @endphp
                    <td>{{ $line->product->code }}</td>
                    <td>{{ $line->product->product_name }}</td>
                    <td>{{ $line->quantity }}</td>
                    <td>{{ $line->unit_price }} </td>
                    <td>{{ $line->remise }}</td>
                    <td>{{ $line->taxe }}</td>
                    <td>
                        {{ $total1 }}
                        {{ $setting->devise }}
                    </td>
                    <td>
                        {{ $total2 }}
                        {{ $setting->devise }}
                    </td>

                </tr>


            @endforeach


            <tr>
                <td colspan="8">
                    <div class="total-part">
                        <div class="total-left w-85 float-left" align="right">
                            <p>Total HT</p>
                            <p>Tax </p>
                            <p>Total TTC</p>
                        </div>
                        <div class="total-right w-15 float-left text-bold" align="right">
                            <p>{{ $totalHT }} {{ $setting->devise }} </p>
                            <p>{{ $totalTax }} {{ $setting->devise }}</p>
                            <p>{{ $totalTTC }} {{ $setting->devise }}</p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</html>
