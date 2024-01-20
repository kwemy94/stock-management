<!DOCTYPE html>
<html>

<head>
    <title>Tech Briva | Inventory</title>
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
    </div><br><br>
    <div class="row">
        <h3 style="text-align: center">{{ $title }}</h3>
    </div>
    
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">#</th>
                <th class="w-50">Produit</th>
                <th class="w-50">Qté initiale</th>
                <th class="w-50">Qté en stock</th>
                <th class="w-50">gap</th>
                <th class="w-50">commentaire</th>
            </tr>
            @php
                $cpt = 1;
            @endphp
            @foreach ($inventories as $inventory )
                <tr align="center">
                    <td>{{ $cpt++ }}</td>
                    <td>{{ $inventory->product->product_name }}</td>
                    <td>{{ $inventory->initial_stock }}</td>
                    <td>{{ $inventory->available_stock }}</td>
                    <td>{{ $inventory->gap }}</td>
                    <td>{{ $inventory->comment }}</td>>

                </tr>
            @endforeach


            
        </table>
    </div>

</html>
