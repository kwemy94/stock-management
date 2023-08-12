@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('product.title') }} </h3>

                    <div class="card-tools">
                        {{-- <a href="{{ route('product.create')}}" class="btn btn-outline-success btn-sm"><span class="fa fa-plus"></span> Add</a> --}}
                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                            data-target="#modal-default"><span class="fa fa-plus"></span> Add</button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ __('product.info.name') }} </th>
                                <th>{{ __('product.info.price') }} </th>
                                <th>{{ __('product.info.sale-price') }} </th>
                                {{-- <th>{{__('product.info.qantity-init')}} </th> --}}
                                <th>{{ __('product.info.qantity-available') }} </th>
                                <th>barcode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @php
                                $cpte = 1;
                            @endphp

                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $cpte++ }}</td>
                                    <td>{{ $product->product_name }} </td>
                                    <td>
                                        {{ $product->unit_price }}
                                    </td>
                                    <td>
                                        {{ $product->sale_price }}
                                    </td>
                                    <td><span
                                            class="badge {{ $product->stock_quantity <= $product->stock_alert ? 'bg-danger' : 'bg-success' }} ">{{ $product->stock_quantity }}</span>
                                    </td>
                                    <td>
                                        {!! $product->barcode !!} <br>
                                        <span>{{ $product->code}}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('product.show', $product->id)}}" class="fas fa-eye" style="color: green"></a>
                                        <a href="{{route('product.edit', $product->id)}}" class="fas fa-pen-alt"
                                            style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                            <form method="post" action="{{route('product.destroy',$product->id)}}" id="form-delete-product{{$product->id}}">
                                                @method('delete')
                                                @csrf
                                                <span  id="btn-delete-product{{$product->id}}" onclick="deleteProduct({{$product->id}})" class="fas fa-trash-alt" style="color: red"></span>
                                            </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center"> Aucun produit disponible</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="card-tools">
                        <ul class="pagination pagination-sm float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('admin.product.modale-create')
@endsection


@section('dashboard-js')
    <script>
        // $('#btn-delete-product').click( () =>{
        //     if (confirm('Voulez-vous supprimer ce produit ??')) {
        //         $('#form-delete-product').submit();
        //     }
        // });

        function deleteProduct(i) {
            if (confirm('Voulez-vous supprimer ce produit ??')) {
                $('#form-delete-product'+i).submit();
            }
        }

        $('#save-product').click((e) => {
            e.preventDefault();
            let url = "{{ route('product.store') }}";
            let datas = {
                product_name: $('#name').val(),
                unit_price: $('#unit_price').val(),
                sale_price: $('#sale_price').val(),
                stock_alert: $('#stock_alert').val(),
                stock_quantity: $('#init_stock').val(),
                description: $('#description').val(),
                category_id: $('#category').val(),
                // product_image: $('product_image')[0].files,
                
            }
            // let datas = $('#product-form').serializeArray();
            console.log(datas);
            if (ControlRequiredFields()) {
            // $('#product-form').submit();

            postData(url, datas).then(res => {

                console.log(res);
                let product = res.product;
                console.log(product.product_name);
                if (!res.error) {
                    // alert(res.message);
                    let color_danger = 'bg-danger';
                    let color_success = 'bg-success';
                    $('#tbody').prepend(
                        '<tr>'+
                            '<td>##</td>'+
                            '<td>'+product.product_name+ '</td>'+
                            '<td>'+product.unit_price +'</td>'+
                            '<td>'+product.sale_price +'</td>'+
                            '<td><span class="badge ' +`${product.stock_quantity <= product.stock_alert ? "bg-danger" : "bg-success"}`+ '">'+ product.stock_quantity  +'</span></td>'+
                            '<td>'+
                                '<span class="fas fa-eye" style="color: green"></span>'+
                                '<span class="fas fa-pen-alt" style="color: #217fff; margin-left: 5px; margin-right: 5px;"></span>'+
                                '<span class="fas fa-trash-alt" style="color: red"></span>'+
                            '</td>'+
                        '</tr>'
                    );

                    $('#modal-default').modal('hide');

                } else{
                    alert("Une erreur s'est broduite");
                }
            }).catch(err => {
                console.log(err.message);
            });
            }

            console.log('Error');
        });
    </script>
@endsection
