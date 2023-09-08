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
                                <a href="{{ route('order.create') }}" class="btn btn-outline-success btn-sm"><span
                                        class="fa fa-plus"></span> Vente</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('Client') }} </th>
                                        <th>{{ __('Montant facture') }} </th>
                                        <th>{{ __('Montant perçu') }} </th>
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
                                            <td>{{ isset($order->customer) ? $order->customer->name : 'Non identifié' }}
                                            </td>
                                            {{-- @dd($order->order_products) --}}
                                            <td>
                                                @php
                                                    $sumAttendu = 0;
                                                    
                                                    foreach ($order->order_products as $item) {
                                                        $sumAttendu += $item->price;
                                                    }
                                                @endphp
                                                {{ $sumAttendu }} {{ $setting->devise }}


                                            </td>
                                            <td>
                                                @php
                                                    $sumPayer = 0;
                                                    foreach ($order->payments as $item) {
                                                        $sumPayer += $item->amount;
                                                    }
                                                @endphp
                                                {{ $sumPayer }} {{ $setting->devise }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $sumPayer == $sumAttendu ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $sumPayer == $sumAttendu ? 'payé' : 'Partiel' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span>{{ $sumPayer != $sumAttendu ? ($sumAttendu - $sumPayer ). $setting->devise: '' }}</span>
                                            </td>
                                            <td style="display: flex !important;">
                                                <a href="{{ route('order.print.invoice', $order->id) }}"
                                                    class="fas fa-print" title="Imprimer"
                                                    style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>

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
                "buttons": ["excel", "pdf","colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });

        function deleteorder(i) {
            if (confirm('Voulez-vous supprimer ce produit ??')) {
                $('#form-delete-order' + i).submit();
            }
        }

        function printInvoice(el) {
            // let data = '<input type="button" id="printPqgeButton" '+
            // 'class="printPageButton" style="display:block; width">
        }
    </script>
@endsection
