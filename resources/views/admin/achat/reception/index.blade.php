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

            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center gap-2">
                    <h3 class="card-title mb-0">Bons de réception</h3>

                    <a href="{{ route('buy-reception.create') }}" class="btn btn-success btn-sm ml-md-auto">
                        <i class="fa fa-plus"></i> Nouveau
                    </a>
                </div>



                <div class="card-body">

                    <div class="table-responsive">
                        <table id="invoice_tab" class="table table-bordered table-striped table-sm">

                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th class="d-none d-md-table-cell">Référence commande</th>
                                    <th>Fournisseur</th>
                                    <th class="d-none d-lg-table-cell">Date réception</th>
                                    <th>Montant</th>
                                    <th class="d-none d-md-table-cell">Créé par</th>
                                    <th>Statut</th>
                                    <th style="width:30px;">Actions</th>
                                </tr>
                            </thead>


                            <tbody>

                                @forelse ($receipts as $receipt)
                                    <tr>

                                        <td>
                                            <a href="{{ route('buy-reception.show', $receipt->id) }}">
                                                {{ $receipt->receipt_number }}
                                            </a>
                                        </td>
                                        <td class="d-none d-md-table-cell">{{ $receipt->purchaseOrder->reference }}</td>
                                        <td>{{ $receipt->purchaseOrder?->supplier?->name }}</td>
                                        <td class="d-none d-md-table-cell">{{ $receipt->receipt_date }}</td>
                                        <td>{{ number_format($receipt->total_amount, 0, ',', ' ') }} FCFA</td>
                                        <td class="d-none d-md-table-cell">{{ $receipt->created_by }}</td>

                                        <td>
                                            @switch($receipt->status)
                                                @case('draft')
                                                    <span class="badge bg-danger">Brouillon</span>
                                                @break

                                                @case('partially_received')
                                                    <span class="badge bg-warning">PARTIEL</span>
                                                @break

                                                @case('received')
                                                    <span class="badge bg-success">Reçue</span>
                                                @break

                                                @default
                                                @break
                                            @endswitch
                                        </td>

                                        @include('admin.achat.reception._actions', ['receipt' => $receipt])

                                    </tr>

                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Aucun bon de réception disponible</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
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
                    "buttons": ["csv"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            });

            function deleteinvoice(i) {
                if (confirm('Voulez-vous supprimer ce produit ??')) {
                    $('#form-delete-invoice' + i).submit();
                }
            }

            const paiementInvoice = (id) => {
                let amount_du = $(`#invoice_${id}`).data('amount_du');
                $('#amount_du').val(amount_du);
                $('#invoice_id').val(id);

            }
            const abc = parseFloat($(`#invoice_${id}`).data('amount_du')) || 0;
            $(document).ready(function() {
                // Récupère le montant initial au chargement
                $('#amount_encaisse').on('input', function() {
                    let initAmount = abc;
                    console.log("détecté", abc);
                    let montant_encaisse = parseFloat($(this).val()) || 0;
                    console.log("Changement ", montant_encaisse);
                    let new_montant_du = initAmount - montant_encaisse;
                    console.log("Chan", new_montant_du);
                    console.log("test");
                    if (new_montant_du < 0) new_montant_du = 0;
                    $('#amount_du').val(new_montant_du.toFixed(1));
                });
            });
        </script>
    @endsection
    @section('dashboard-js')
        <script>
            $('#save-pay').click((e) => {
                e.preventDefault();
                if (ControlRequiredFields()) {
                    $('#pay-form').submit()
                }
            });
        </script>
    @endsection
