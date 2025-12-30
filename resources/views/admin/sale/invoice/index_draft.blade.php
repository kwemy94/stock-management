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
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <h3 class="card-title w-100">
                                <i class="fas fa-file-invoice mr-1"></i> Commandes à confirmer
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="invoice_tab" class="table table-hover table-sm mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Facture</th>
                                            <th>Date</th>
                                            <th class="text-right">Montant</th>
                                            <th class="text-right">Encaissé</th>
                                            <th class="text-right">Reste</th>
                                            <th class="text-center">Statut</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($draftInvoices as $invoice)
                                            <tr>
                                                <td><strong>{{ $invoice->invoice_number }}</strong></td>

                                                <td class="text-muted">
                                                    {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}
                                                </td>

                                                <td class="text-right font-weight-bold">
                                                    {{ number_format($invoice->montant_facture, 0, ',', ' ') }}
                                                </td>

                                                <td class="text-right text-success">
                                                    {{ number_format($invoice->montant_encaisse ?? 0, 0, ',', ' ') }}
                                                </td>

                                                <td class="text-right text-danger">
                                                    {{ number_format($invoice->montant_du, 0, ',', ' ') }}
                                                </td>

                                                <td class="text-center">
                                                    @switch($invoice->status)
                                                        @case('draft')
                                                            <span class="badge badge-danger">Brouillon</span>
                                                        @break

                                                        @case('confirmed')
                                                            <span class="badge badge-primary">Confirmée</span>
                                                        @break

                                                        @case('proformat')
                                                            <span class="badge badge-warning">Proforma</span>
                                                        @break

                                                        @case('Payé')
                                                            <span class="badge badge-success">Payée</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <a class="text-secondary" href="#" role="button"
                                                            data-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right shadow">

                                                            {{-- Détails --}}
                                                            <a class="dropdown-item"
                                                                href="{{ route('sale.invoice.show', $invoice->id) }}">
                                                                <i class="fas fa-eye text-info mr-2"></i> Détails
                                                            </a>

                                                            {{-- Paiement --}}
                                                            @if ($invoice->status == 'confirmed')
                                                                <a class="dropdown-item text-success" href="#"
                                                                    onclick="paiementInvoice({{ $invoice->id }})"
                                                                    data-toggle="modal" data-target="#modal-secondary"
                                                                    data-amount_du="{{ $invoice->montant_du }}">
                                                                    <i class="fas fa-cash-register mr-2"></i> Encaisser
                                                                </a>
                                                            @endif

                                                            {{-- Impression --}}
                                                            @if (in_array($invoice->status, ['confirmed', 'proformat', 'Payé']))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('sale.invoice.print', $invoice->id) }}">
                                                                    <i class="fas fa-print text-secondary mr-2"></i>
                                                                    Imprimer
                                                                </a>
                                                            @endif

                                                            {{-- Modifier / Supprimer --}}
                                                            @if (!in_array($invoice->status, ['confirmed', 'Payé']))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('sale.invoice.edit', $invoice->id) }}">
                                                                    <i class="fas fa-edit text-primary mr-2"></i> Modifier
                                                                </a>

                                                                <div class="dropdown-divider"></div>

                                                                <form method="POST"
                                                                    action="{{ route('product.destroy', $invoice->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                                                    </button>
                                                                </form>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4">
                                                        <i class="fas fa-folder-open mb-2 d-block"></i>
                                                        Aucune facture disponible
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>


                                        <tfoot class="thead-light">
                                            <tr>
                                                <th>Facture</th>
                                                <th>Date</th>
                                                <th class="text-right">Montant</th>
                                                <th class="text-right">Encaissé</th>
                                                <th class="text-right">Reste</th>
                                                <th class="text-center">Statut</th>
                                                <th class="text-center">Actions</th>
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
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('sale.invoice.payment') }}" method="post"
                                                    id="pay-form">
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
                                                                        <option value="{{ $mode->id }}">
                                                                            {{ $mode->name }}
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
                                                                    name="date_pay" id="date_pay"
                                                                    value="{{ date('Y-m-d') }}">
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
