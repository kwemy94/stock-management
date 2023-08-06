@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('product.title') }} </h3>

                    <div class="card-tools">
                        <ul class="pagination pagination-sm float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
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
                                {{-- <th>{{__('product.info.qantity-init')}} </th> --}}
                                <th>{{ __('product.info.qantity-available') }} </th>
                                <th>Action</th>
                                <th style="width: 40px">Label</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cpte = 1;
                            @endphp

                            @forelse ($products as $product)
                                <tr>
                                    <td>{{$cpte ++ }}</td>
                                    <td>{{$product->product_name }} </td>
                                    <td>
                                        {{$product->unit_price}}
                                    </td>
                                    <td><span class="badge {{$product->stock_quantity <= $product->stock_alert ? 'bg-danger' : 'bg-success'}} ">{{$product->stock_quantity}}</span></td>
                                    <td>
                                        <span class="fas fa-eye"></span>
                                        <span class="fas fa-pen"></span>
                                        <span class="fas fa-trash-alt"></span>
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
                <!-- /.card-body -->
            </div>

        </div>
    </section>
@endsection
