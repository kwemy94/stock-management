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
                            <h3 class="card-title">{{ __('Liste des ventes') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('order.create')}}" class="btn btn-outline-success btn-sm"><span class="fa fa-plus"></span> Vente</a>
                                </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('Client') }} </th>
                                        <th>{{ __('Total') }} </th>
                                        <th>{{ __('Payer') }} </th>
                                        <th>{{ __('Status') }} </th>
                                        <th>{{ __('Reste') }}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cpt = 1;
                                    @endphp
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $cpt++ }}</td>
                                            <td>{{ $order->customers->name }} </td>
                                            <td>{{ $order->order_product->price }} x fois </td>
                                            <td>
                                                {{ $order->payments->amount }}
                                            </td>
                                            <td>
                                                {{-- <span
                                                    class="badge {{ $order->stock_quantity <= $order->stock_alert ? 'bg-danger' : 'bg-success' }} ">{{ $order->stock_quantity }}
                                                </span> --}}
                                                    comparaison à faire
                                            </td>
                                            <td>
                                                <span>{{ "a calculer" }}</span>
                                            </td>
                                            <td style="display: flex !important;">
                                                
                                                {{-- <form method="post" action="{{ route('order.destroy', $order->id) }}"
                                                    id="form-delete-order{{ $order->id }}">
                                                    <a href="{{ route('order.show', $order->id) }}" class="fas fa-eye"
                                                        style="color: green"></a>
                                                    <a href="{{ route('order.edit', $order->id) }}" class="fas fa-pen-alt"
                                                        style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                                        
                                                    @csrf
                                                    @method('delete')
                                                    <span id="btn-delete-order{{ $order->id }}"
                                                        onclick="deleteorder({{ $order->id }})"
                                                        class="fas fa-trash-alt" style="color: rgb(248, 38, 38)"></span>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" style="text-align: center"> Aucun ordre disponible</td>
                                        </tr>
                                    @endforelse


                                </tbody>
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

    <script src="{{ asset('dashboard-template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
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
    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard-template/dist/js/adminlte.min.js') }}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });

        function deleteorder(i) {
            if (confirm('Voulez-vous supprimer ce produit ??')) {
                $('#form-delete-order' + i).submit();
            }
        }
    </script>
@endsection