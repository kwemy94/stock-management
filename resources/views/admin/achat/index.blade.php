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
                            <h3 class="card-title">{{ __('Liste approvisionnement') }} </h3>
        
                            <div class="card-tools">
                                <a href="{{ route('achat.create') }}" class="btn btn-outline-success btn-sm"><span
                                        class="fa fa-plus"></span> Add</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('product.info.name') }} </th>
                                        <th>{{ __('supplier.name') }} fournisseur </th>
                                        <th>{{ __('product.info.qantity') }} </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @php
                                        $cpte = 1;
                                    @endphp
        
                                    @forelse ($achats as $achat)
                                        <tr>
                                            <td>{{ $cpte++ }}</td>
                                            <td>{{ $achat->product->product_name }} </td>
                                            <td>
                                                {{ $achat->supplier->name }}
                                            </td>
                                            <td>
                                                {{ $achat->quantity }}
                                            </td>
                                            <td>
        
                                                <form method="post" action="{{ route('achat.destroy', $achat->id) }}"
                                                    id="form-delete-achat{{ $achat->id }}">
                                                    
                                                    <a href="{{ route('achat.edit', $achat->id) }}" class="fas fa-pen-alt"
                                                        style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
        
                                                    @csrf
                                                    @method('delete')
                                                    <span id="btn-delete-achat{{ $achat->id }}"
                                                        onclick="deleteachat({{ $achat->id }})" class="fas fa-trash-alt"
                                                        style="color: red"></span>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center"> Aucun produit disponible</td>
                                        </tr>
                                    @endforelse
        
                                </tbody>
                            </table>
                        </div>
                        
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

        function deleteachat(i) {
            if (confirm('Voulez-vous supprimer cet approvisionnement ??')) {
                $('#form-delete-achat' + i).submit();
            }
        }
    </script>
@endsection
