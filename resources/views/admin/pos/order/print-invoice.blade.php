<!DOCTYPE html>
<html>

<head>
    <title>Tech Briva | invoice</title>
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
    <div class="logo">
        <img src="{{ isset($setting->logo)? 'data:image/png;base64,' . base64_encode(file_get_contents('storage/images/logo/' . $setting->logo)) : 'data:image/png;base64,' . base64_encode(file_get_contents('front-template/assets/images/logo/logo.png')) }}"
            width="50px" height="50px" alt="logo">
    </div>
    {{-- <div class="head-title">
        <h1 class="text-center m-0 p-0">Invoice</h1>
    </div> --}}
    <div class="add-detail mt-10">
        {{-- @dd($orders): --}}
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">Invoice Id - <span class="gray-color">#00{{ $order_id }} </span></p>
            <p class="m-0 pt-5 text-bold w-100">Order Id - <span class="gray-color">R00{{ $order_id }}I</span></p>
            <p class="m-0 pt-5 text-bold w-100">Order Date - <span class="gray-color">{{ date('d-M-Y H:m:s') }}</span>
            </p>
        </div>


        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">From</th>
                <th class="w-50">To</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p>Ets : <strong>{{ isset($setting) ? $setting->app_name : 'Tech Briva' }} </strong></p>
                        <p>Tél : <strong>{{ isset($setting) ? $setting->phone : '+237 672517118' }} </strong></p>
                        <p>Email : <strong>{{ isset($setting) ? $setting->email : 'infos@techbriva.com' }} </strong></p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <p>Nom : <strong>{{ isset($customer) ? $customer->name : 'xxx' }} </strong></p>
                        <p>Tél : <strong>{{ isset($customer) ? $customer->phone : 'xxx' }} </strong></p>
                        <p>Email : <strong>{{ isset($customer) ? $customer->email : 'xxx' }} </strong></p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    {{-- <div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Payment Method</th>
            <th class="w-50">Shipping Method</th>
        </tr>
        <tr>
            <td>Cash On Delivery</td>
            <td>Free Shipping - Free Shipping</td>
        </tr>
    </table>
</div> --}}
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">Code</th>
                <th class="w-50">Produit</th>
                <th class="w-50">Price</th>
                <th class="w-50">Qty</th>
                <th class="w-50">total</th>
                <th class="w-50">TVA</th>
                <th class="w-50">Grand Total</th>
            </tr>
            @php
                $total = 0;
                $totalTax = 0;
            @endphp
            @for ($i = 0; $i < count($orderProducts); $i++)
                <tr align="center">
                    @php
                        $total += $orderProducts[$i]['quantity'] * $orderProducts[$i]->product->sale_price;
                        // $totalTax += (19.25/100) * $orderProducts[$i]->product->sale_price * $orderProducts[$i]['quantity'];
                        $totalTax += 0;
                    @endphp
                    <td>{{ $orderProducts[$i]->product->code }}</td>
                    <td>{{ $orderProducts[$i]->product->product_name }}</td>
                    <td>{{ $orderProducts[$i]->product->sale_price }} {{$setting->devise}}</td>
                    <td>{{ $orderProducts[$i]['quantity'] }}</td>
                    <td>{{ $orderProducts[$i]['quantity'] * $orderProducts[$i]->product->sale_price }} {{$setting->devise}}</td>
                    <td>0</td>
                    <td>
                        {{-- Ajouter la taxe au montant total --}}
                        {{ $orderProducts[$i]['quantity'] * $orderProducts[$i]->product->sale_price }} {{$setting->devise}}
                    </td>

                </tr>
            @endfor


            {{-- @endforeach --}}


            <tr>
                <td colspan="7">
                    <div class="total-part">
                        <div class="total-left w-85 float-left" align="right">
                            <p>Sub Total</p>
                            <p>Tax </p>
                            <p>Total Payable</p>
                        </div>
                        <div class="total-right w-15 float-left text-bold" align="right">
                            <p>{{ $total }} {{ $setting->devise }} </p>
                            <p>{{ $totalTax }} {{ $setting->devise }}</p>
                            <p>{{ $total + $totalTax }} {{ $setting->devise }}</p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</html>
