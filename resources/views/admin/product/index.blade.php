@extends('admin.layouts.app')

@section('dashboard-datatable-css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dashboard-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/dist/css/adminlte.min.css') }}">
@endsection



@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('product.title') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('product.create')}}" class="btn btn-outline-success btn-sm"><span class="fa fa-plus"></span> Add</a>
                                <a href="{{ route('barcode.to.pdf')}}" class="btn btn-outline-secondary btn-sm" target="_blank"><span class="fa fa-print"></span> Barcode</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('product.info.name') }} </th>
                                        <th>{{ __('Image') }} </th>
                                        <th>{{ __('product.info.sale-price') }} </th>
                                        {{-- <th>{{__('product.info.qantity-init')}} </th> --}}
                                        <th>{{ __('product.info.qantity-available') }} </th>
                                        <th>barcode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cpt = 1;
                                    @endphp
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>{{ $cpt++ }}</td>
                                            <td>{{ $product->product_name }} </td>
                                            <td> <img src='{{asset("storage/images/products/$product->product_image")}}' width="40px" height="40px" alt="" > </td>
                                            <td>
                                                {{ $product->sale_price }}
                                            </td>
                                            <td><span
                                                    class="badge {{ $product->stock_quantity <= $product->stock_alert ? 'bg-danger' : 'bg-success' }} ">{{ $product->stock_quantity }}</span>
                                            </td>
                                            <td>
                                                <span>{{ $product->code }}</span>
                                            </td>
                                            <td style="display: flex !important;">
                                                
                                                <form method="post" action="{{ route('product.destroy', $product->id) }}"
                                                    id="form-delete-product{{ $product->id }}">
                                                    <a href="{{ route('product.show', $product->id) }}" class="fas fa-eye"
                                                        style="color: green"></a>
                                                    <a href="{{ route('product.edit', $product->id) }}" class="fas fa-pen-alt"
                                                        style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                                        
                                                    @csrf
                                                    @method('delete')
                                                    <span id="btn-delete-product{{ $product->id }}"
                                                        onclick="deleteProduct({{ $product->id }})"
                                                        class="fas fa-trash-alt" style="color: rgb(248, 38, 38)"></span>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" style="text-align: center"> Aucun produit disponible</td>
                                        </tr>
                                    @endforelse


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('product.info.name') }} </th>
                                        <th>{{ __('Image') }} </th>
                                        <th>{{ __('product.info.sale-price') }} </th>
                                        {{-- <th>{{__('product.info.qantity-init')}} </th> --}}
                                        <th>{{ __('product.info.qantity-available') }} </th>
                                        <th>barcode</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection




@section('dashboard-datatable-js')
    <!-- jQuery -->
    <script src="{{ asset('dashboard-template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('dashboard-template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });

        function deleteProduct(i) {
            if (confirm('Voulez-vous supprimer ce produit ??')) {
                $('#form-delete-product' + i).submit();
            }
        }
    </script>
@endsection