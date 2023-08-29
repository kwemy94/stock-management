<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tech Briva</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="">
        
        <h2 class="mb-3">{{env('APP_NAME') }} : {{$title}} / {{$date}} </h2>
        <table class="table table-bordered">
            <thead>
                <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Date d'enregistrement</th>
                </tr>
            </thead>
            @php
                $cpte = 1;
            @endphp
            <tbody>
                @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $cpte++ }}</th>
                    <td>{{ $product->product_name }}</td>
                    <td>
                        <img height="20px" width="20px" src="data:image/png;base64, {!! base64_encode($product->barcode) !!} ">
                    </td>
                    <td>{{$product->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>