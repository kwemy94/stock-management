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

            <div class="card card-outline card-primary">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title mb-0">
            <i class="fas fa-file-alt mr-1"></i> Bons de commandes
        </h3>

        <a href="{{ route('buy.command.create') }}" class="btn btn-sm btn-success">
            <i class="fa fa-plus"></i> Nouveau
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="invoice_tab" class="table table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Numéro</th>
                        <th>Fournisseur</th>
                        <th>Date</th>
                        <th class="text-right">Montant</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center" style="width:30px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($commands as $command)
                    <tr>
                        <td>
                            <a href="{{ route('buy-command-order.show', $command->id) }}">
                                {{ $command->reference }}
                            </a>
                        </td>
                        <td>{{ $command->supplier->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($command->date_command)->format('d/m/Y') }}</td>
                        <td class="text-right font-weight-bold">
                            {{ number_format($command->amount, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="text-center">
                            @switch($command->status)
                                @case('draft')
                                    <span class="badge badge-danger">Brouillon</span>
                                @break
                                @case('send')
                                    <span class="badge badge-secondary">Envoyée</span>
                                @break
                                @case('confirmed')
                                    <span class="badge badge-primary">Confirmée</span>
                                @break
                                @case('received')
                                    <span class="badge badge-success">Livrée</span>
                                @break
                                @case('partially_received')
                                    <span class="badge badge-warning">Partiellement livrée</span>
                                @break
                            @endswitch
                        </td>

                        {{-- Actions regroupées --}}
                        {{-- <td class="text-center">
                            <div class="dropdown">
                                <a href="#" class="text-secondary" data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow-sm">

                                    <a class="dropdown-item"
                                       href="{{ route('buy-command-order.show', $command->id) }}">
                                        <i class="fas fa-eye text-info mr-2"></i> Détails
                                    </a>

                                    <a class="dropdown-item"
                                       href="{{ route('buy.command.edit', $command->id) }}">
                                        <i class="fas fa-edit text-primary mr-2"></i> Modifier
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <form method="POST" action="{{ route('buy.command.destroy', $command->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </td> --}}
                        @include('admin.achat.command._actions', ['command' => $command])

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open d-block mb-2"></i>
                            Aucune commande disponible
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
