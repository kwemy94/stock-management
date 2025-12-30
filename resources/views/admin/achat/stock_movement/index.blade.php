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
                        <i class="fas fa-file-alt mr-1"></i> Listing du mouvement de stock
                    </h3>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <div class="d-flex align-items-center justify-content-between mb-2">

                            {{-- Jour précédent --}}
                            <a href="{{ route('listing.index', ['date' => $prevDate->toDateString()]) }}"
                                class="text-primary px-2" title="Jour précédent">
                                <i class="fas fa-chevron-left"></i>
                            </a>

                            {{-- Date courante + sélecteur --}}
                            <form method="GET" class="d-flex align-items-center mb-0">
                                <strong class="mx-2">
                                    {{ $currentDate->format('d/m/Y') }}
                                </strong>

                                <input type="date" name="date" value="{{ $currentDate->toDateString() }}"
                                    class="form-control form-control-sm ml-2" style="width: 140px"
                                    onchange="this.form.submit()">
                            </form>

                            {{-- Jour suivant --}}
                            <a href="{{ route('listing.index', ['date' => $nextDate->toDateString()]) }}"
                                class="text-primary px-2" title="Jour suivant">
                                <i class="fas fa-chevron-right"></i>
                            </a>

                        </div>


                        <table id="invoice_tab" class="table table-hover table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Référence</th>
                                    <th>Quantité</th>
                                    <th>Type de mouvement</th>
                                    <th class="">Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($movements as $mvt)
                                    <tr>
                                        <td> {{ $mvt->product->product_name }} </td>
                                        <td>{{ $mvt->reference }}</td>
                                        <td>{{ $mvt->quantity }}</td>
                                        <td
                                            class="font-weight-bold {{ $mvt->movement_type == 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ $mvt->movement_type }}</td>
                                        <td class="">{{ $mvt->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-folder-open d-block mb-2"></i>
                                            Aucun mouvement de stock disponible
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

        $("#invoice_tab").DataTable({
            paging: false,
            responsive: true,
            ordering: true,
            searching: false,
            buttons: ["csv"]
        });
    </script>
@endsection
