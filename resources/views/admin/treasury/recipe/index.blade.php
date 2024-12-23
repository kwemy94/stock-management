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
                            <h3 class="card-title">{{ __('Liste des clients') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('expense.create')}}" class="btn btn-outline-success btn-sm">
                                    <span class="fa fa-plus"></span> Add
                                </a>
                                
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('Intitulé') }} </th>
                                        <th>{{ __('Référence') }} </th>
                                        <th>{{ __('date') }} </th>
                                        <th>{{ __('Montant') }} </th>
                                        <th>{{ __('Montant dû') }} </th>
                                        <th>{{ __('Statut') }} </th>
                                        <th>{{ __('Crée par') }} </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cpt = 1;
                                    @endphp
                                    @forelse ($recipes as $recipe)
                                        <tr>
                                            <td>{{ $cpt++ }}</td>
                                            <td>{{ $recipe->intitule }}</td>
                                            <td>{{ $recipe->reference }}</td>
                                            <td>{{ $recipe->date }}</td>
                                            <td>{{ $recipe->amount }}</td>
                                            <td>{{ $recipe->amount_du }}</td>
                                            <td>
                                                @if ($recipe->status == 1)
                                                <span class='badge bg-success'>payé </span>
                                                @else
                                                <span class='badge bg-primary'> A payer </span>
                                                @endif
                                            </td>
                                            <td>{{ $recipe->created_by }}</td>
                                            <td>
                                                @if ($recipe->status != 1)
                                                    <a href="#" class="fas fa-save" title="Enregister un paiement"
                                                        style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                                    <a href="{{route('expense.edit', $recipe->id)}}" class="fas fa-pen" title="Editer"
                                                        style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" style="text-align: center"> Aucun recette disponible</td>
                                        </tr>
                                    @endforelse
                                    


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('Intitulé') }} </th>
                                        <th>{{ __('Référence') }} </th>
                                        <th>{{ __('date') }} </th>
                                        <th>{{ __('Montant') }} </th>
                                        <th>{{ __('Montant dû') }} </th>
                                        <th>{{ __('Statut') }} </th>
                                        <th>{{ __('Crée par') }} </th>
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
                "buttons": ["excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });

        function deleteCustomer(i) {
            if (confirm('Voulez-vous supprimer cet utilisateur ??')) {
                $('#form-delete-customer' + i).submit();
            }
        }
    </script>
@endsection