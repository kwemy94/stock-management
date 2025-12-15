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
    <style>
        .table-hover tbody tr {
            cursor: pointer;
        }

        .dropdown-menu {
            border-radius: 6px;
            font-size: 0.9rem;
        }
    </style>
@endsection



@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-success">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title m-0">
                                <i class="fas fa-cash-register mr-1 text-success"></i>
                                Liste des factures POS
                            </h3>

                            <a href="{{ route('order.create') }}" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Continuer à vendre
                            </a>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-hover table-sm mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Client</th>
                                            <th class="text-right">Montant</th>
                                            <th class="text-right">Payé</th>
                                            <th class="text-center">Statut</th>
                                            <th class="text-right">Reste</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php $cpt = 1; @endphp
                                        @forelse ($orders as $order)
                                            @php
                                                $sumAttendu = $order->order_products->sum('price');
                                                $sumPayer = $order->payments->sum('amount');
                                                $reste = $sumAttendu - $sumPayer;
                                            @endphp

                                            <tr>
                                                <td>{{ $cpt++ }}</td>

                                                <td>
                                                    {{ $order->customer->name ?? 'Non identifié' }}
                                                </td>

                                                <td class="text-right font-weight-bold">
                                                    {{ number_format($sumAttendu, 0, ',', ' ') }} {{ $setting->devise }}
                                                </td>

                                                <td class="text-right text-success">
                                                    {{ number_format($sumPayer, 0, ',', ' ') }} {{ $setting->devise }}
                                                </td>

                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-{{ $sumPayer == $sumAttendu ? 'success' : 'warning' }}">
                                                        {{ $sumPayer == $sumAttendu ? 'Payé' : 'Partiel' }}
                                                    </span>
                                                </td>

                                                <td class="text-right text-danger">
                                                    {{ $reste > 0 ? number_format($reste, 0, ',', ' ') . ' ' . $setting->devise : '-' }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <a href="#" class="text-secondary" data-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right shadow-sm">

                                                            <a href="{{ route('order.print.invoice', $order->id) }}"
                                                                class="dropdown-item" target="_blank">
                                                                <i class="fas fa-print text-primary mr-2"></i>
                                                                Imprimer
                                                            </a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="fas fa-folder-open mb-2 d-block"></i>
                                                    Aucun ordre disponible
                                                </td>
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
                "buttons": ["excel", "pdf", "colvis"]
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
