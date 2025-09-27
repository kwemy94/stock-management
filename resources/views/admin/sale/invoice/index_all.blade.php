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
                        <div class="card-header text-center">
                            <h3 class="card-title w-100">{{ __('Factures') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="invoice_tab" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Numéro facture</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Montant encaissé</th>
                                        <th>Montant dû</th>
                                        <th style="width: 40px">Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cpt = 1;
                                    @endphp
                                    @forelse ($saleInvoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice->invoice_number }}</td>
                                            <td>{{ $invoice->date }}</td>
                                            <td>{{ $invoice->montant_facture }}</td>
                                            <td>{{ $invoice->montant_encaisse??0 }}</td>
                                            <td>{{ $invoice->montant_du }}</td>
                                            <td>
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

                                                    @default
                                                @endswitch

                                            </td>
                                            <td style="display: flex !important;">

                                                <form method="post" action="{{ route('product.destroy', $invoice->id) }}"
                                                    id="form-delete-invoice{{ $invoice->id }}">
                                                    {{-- <a href="{{ route('invoice.show', $invoice->id) }}" class="fas fa-eye"
                                                        style="color: green"></a> --}}
                                                    @if ($invoice->status != 'confirmed')
                                                        <a href="{{ route('sale.invoice.edit', $invoice->id) }}"
                                                            class="fas fa-pen-alt"
                                                            style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                                        @csrf
                                                        @method('delete')
                                                        <span id="btn-delete-invoice{{ $invoice->id }}"
                                                            onclick="deleteinvoice({{ $invoice->id }})"
                                                            class="fas fa-trash-alt" style="color: rgb(248, 38, 38)"></span>
                                                    @endif

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
                                            <th>Numéro facture</th>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            {{-- <th>Montant encaissé</th> --}}
                                            <th>Montant dû</th>
                                            <th style="width: 40px">Statut</th>
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
                $("#invoice_tab").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    "buttons": ["excel"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            });

            function deleteinvoice(i) {
                if (confirm('Voulez-vous supprimer ce produit ??')) {
                    $('#form-delete-invoice' + i).submit();
                }
            }
        </script>
    @endsection
