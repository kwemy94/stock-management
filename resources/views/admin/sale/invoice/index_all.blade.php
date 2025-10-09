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
                                            <td>{{ $invoice->montant_encaisse ?? 0 }}</td>
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

                                                    @case('Payé')
                                                        <span class="badge bg-success">{{ $invoice->status }}</span>
                                                    @break

                                                    @default
                                                @endswitch

                                            </td>
                                            <td style="display: flex !important;">
                                                @if ($invoice->status == 'confirmed')
                                                    <a href="#" title="Payé" class="fas fa-check"
                                                        id="invoice_{{ $invoice->id }}"
                                                        onclick="paiementInvoice({{ $invoice->id }})" data-toggle="modal"
                                                        data-target="#modal-secondary"
                                                        data-amount_du={{ $invoice->montant_du }} {{-- data-amount_ ={{ $invoice->montant_facture }} --}}
                                                        style="color: #09c240; margin-left: 5px; margin-right: 5px;"></a>
                                                @endif
                                                <a href="{{ route('sale.invoice.show', $invoice->id) }}" title="Détails" class="fas fa-eye"
                                                    style=" margin-left: 5px; margin-right: 5px;"></a>

                                                <form method="post" action="{{ route('product.destroy', $invoice->id) }}"
                                                    id="form-delete-invoice{{ $invoice->id }}">
                                                    {{-- <a href="{{ route('invoice.show', $invoice->id) }}" class="fas fa-eye"
                                                        style="color: green"></a> --}}
                                                    @if (!in_array($invoice->status, ['confirmed', 'Payé']))
                                                        <a href="{{ route('sale.invoice.edit', $invoice->id) }}"
                                                            class="fas fa-pen-alt"
                                                            style="color: #37383a; margin-left: 5px; margin-right: 5px;"></a>
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
                                            <th>Montant encaissé</th>
                                            <th>Montant dû</th>
                                            <th style="width: 40px">Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div class="modal fade" id="modal-secondary">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-white">
                                            <div class="modal-header">
                                                <h4 class="modal-title"
                                                    style="display: flex; justify-content: center; align-items: center;">
                                                    Enregistrer un paiment
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('sale.invoice.payment') }}" method="post" id="pay-form">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row" style="display:flex;gap:10px">
                                                        <div class="form-group">
                                                            <label for="name">{{ __('Montant dû') }}</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control-border border-width-2 required"
                                                                name="amount" id="amount_du" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">{{ __('Montant encaissé') }}
                                                                <em>*</em></label>
                                                            <input type="text"
                                                                class="form-control form-control-border border-width-2 required"
                                                                name="amount_encaisse" id="amount_encaisse">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="mode">Mode de paiement <em>*</em></label>
                                                            <select name="mode_id"
                                                                class="custom-select form-control-border border-width-2 required"
                                                                id="mode">
                                                                <option value="" disabled selected>Mode de paiement
                                                                </option>
                                                                @forelse ($paymentModes as $mode)
                                                                    <option value="{{ $mode->id }}">{{ $mode->name }}
                                                                    </option>
                                                                @empty
                                                                    <option value="" disabled>Aucun mode de paiement
                                                                        trouvé</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">{{ __('Date de paiement') }}
                                                                <em>*</em></label>
                                                            <input type="date"
                                                                class="form-control form-control-border border-width-2 required"
                                                                name="date_pay" id="date_pay" value="{{ date('Y-m-d') }}">
                                                        </div>
                                                        <input type="hidden" name='invoice_id' id="invoice_id">


                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light"
                                                        data-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-outline-success"
                                                        id="save-pay">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
