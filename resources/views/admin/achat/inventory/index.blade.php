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
                                <a href="{{ route('histo.inventaire') }}"  class="btn btn-outline-success btn-sm">
                                    <span class="fa fa-eye"></span> {{ __('Historique') }}</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('store.inventory') }}" method="POST">
                                @csrf
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>{{ __('Produit') }} </th>
                                            <th>{{ __('Stock initial') }} </th>
                                            <th>{{ __('Stock disponible') }} </th>
                                            <th>{{ __('Confirmmer le stock') }} </th>
                                            <th>{{ __('Commentaire') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cpt = 1;
                                            // $inventories = [];
                                        @endphp
                                        @foreach($inventories as $inventory)
                                        <input type="text" name="product_id[]" value="{{ $inventory->product_id }}" hidden>
                                        <input type="text" name="supplier_id[]" value="{{ $inventory->supplier_id }}" hidden>
                                        <input type="text" name="initial_stock[]" value="{{ $inventory->total }}" hidden>
                                        <input type="text" name="available_stock[]" value="{{ $inventory->product->stock_quantity }}" hidden>
                                            <tr>
                                                <td>{{ $cpt++ }}</td>
                                                <td>{{ $inventory->product->product_name }} </td>
                                                <td>{{ $inventory->total }} </td>
                                                <td>{{ $inventory->product->stock_quantity }} </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-border border-width-2 required"
                                                        name="quantity[]" id="quantity_{{ $inventory->id }}" min="0" required>
                                                </td>
                                                <td>
                                                    <textarea name="comment[]" id="comment_{{ $inventory->id }}" 
                                                        style="resize: none;" cols="20" rows="2" class="form-control"></textarea>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6" style="text-align: center">
                                                <button class="btn btn-primary">Valider</button>
                                            </td>
                                        </tr>
                                        
    
    
                                    </tbody>
                                </table>
                            </form>
                            
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
