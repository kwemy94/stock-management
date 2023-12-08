@extends('admin.layouts.app')



@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Historique des inventaires') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('inventory.create') }}" class="btn btn-outline-success btn-sm"><span
                                        class="fa fa-plus"></span> Add</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('Description') }} </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cpt = 1;
                                        $inventories = [];
                                    @endphp
                                    @forelse ($inventories as $inventory)
                                        <tr>
                                            <td>{{ $cpt++ }}</td>
                                            <td>{{ $inventory->name }} </td>

                                            <td style="display: flex !important;">
                                                <span onclick="deleteinventory({{ $inventory->id }})" class="fas fa-print"
                                                    style="color: rgb(67, 96, 226)"></span>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" style="text-align: center"> Aucun produit disponible</td>
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
                "buttons": ["pdf"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });

        function deleteinventory(i) {
            if (confirm('Voulez-vous supprimer cette inventoryé ??')) {
                $('#form-delete-inventory' + i).submit();
            }
        }
    </script>
@endsection
