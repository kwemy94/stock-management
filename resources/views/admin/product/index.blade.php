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
        /* Style plus light */
        .card {
            border-radius: 10px;
            border: 1px solid #e5e5e5 !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            background: #fafafa !important;
            border-bottom: 1px solid #e6e6e6;
            padding: 15px 20px;
        }

        .card-title {
            font-weight: 600;
            font-size: 18px;
        }

        table.dataTable {
            border: none !important;
        }

        table.dataTable thead tr {
            background: #f7f7f7 !important;
            border-bottom: 2px solid #e3e3e3;
        }

        table.dataTable th {
            font-weight: 600;
            color: #555;
        }

        table.dataTable td {
            padding: 10px 8px !important;
            vertical-align: middle;
        }

        img.product-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .badge {
            padding: 5px 8px;
            font-size: 12px;
            border-radius: 6px;
        }

        /* Boutons */
        .btn-sm {
            border-radius: 6px !important;
        }

        .card-tools .btn {
            margin-left: 5px;
        }

        /* Icônes actions */
        .table-actions i {
            font-size: 16px;
            cursor: pointer;
            margin-right: 10px;
            opacity: 0.85;
            transition: 0.2s;
        }

        .table-actions i:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        /* Modal */
        #printBarcodeModal .modal-content {
            border-radius: 12px;
        }
    </style>
@endsection



@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('product.title') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('product.create') }}" class="btn btn-outline-success btn-sm"><span
                                        class="fa fa-plus"></span> Add</a>
                                <a href="{{ route('barcode.to.pdf') }}" class="btn btn-outline-secondary btn-sm"
                                    target="_blank"><span class="fa fa-print"></span> Barcode</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('product.info.name') }} </th>
                                        <th>{{ __('Image') }} </th>
                                        <th>{{ __('product.info.sale-price') }} </th>
                                        {{-- <th>{{__('product.info.qantity-init')}} </th> --}}
                                        <th>{{ __('product.info.qantity-available') }} </th>
                                        <th>barcode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cpt = 1;
                                    @endphp
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>{{ $cpt++ }}</td>
                                            <td>{{ $product->product_name }} </td>
                                            <td> <img src='{{ asset("storage/images/products/$product->product_image") }}'
                                                    class="product-img" alt=""> </td>
                                            <td>
                                                {{ $product->sale_price }}
                                            </td>
                                            <td><span
                                                    class="badge {{ $product->stock_quantity <= $product->stock_alert ? 'bg-danger' : 'bg-success' }} ">{{ $product->stock_quantity }}</span>
                                            </td>
                                            <td>
                                                <span>{{ $product->code }}</span>
                                            </td>
                                            <td class="table-actions">
                                                <a href="{{ route('product.edit', $product->id) }}">
                                                    <i class="fas fa-pen" style="color:#2274ff"></i>
                                                </a>

                                                @if ($product->stock_quantity > 0)
                                                    <i class="fas fa-barcode" title="Imprimer code"
                                                        style="cursor:pointer; margin-right:8px;"
                                                        onclick="openPrintModal('{{ $product->id }}', '{{ $product->product_name }}', '{{ $product->code }}')">
                                                    </i>
                                                @endif

                                                <i class="fas fa-trash" style="color:#e52b2b"
                                                    onclick="deleteProduct({{ $product->id }})">
                                                </i>

                                                <form method="post" action="{{ route('product.destroy', $product->id) }}"
                                                    id="form-delete-product{{ $product->id }}">
                                                    @csrf
                                                    @method('delete')
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
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('product.info.name') }} </th>
                                        <th>{{ __('Image') }} </th>
                                        <th>{{ __('product.info.sale-price') }} </th>
                                        {{-- <th>{{__('product.info.qantity-init')}} </th> --}}
                                        <th>{{ __('product.info.qantity-available') }} </th>
                                        <th>barcode</th>
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

    <!-- Modal impression code-barre -->
    <div class="modal fade" id="printBarcodeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Imprimer code-barres</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="barcode_product_id">
                    <input type="hidden" id="barcode_product_code">
                    <input type="hidden" id="barcode_product_name">

                    <label>Quantité à imprimer</label>
                    <input type="number" id="barcode_qty" class="form-control" value="6" min="5">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" onclick="printBarcode()">Imprimer</button>
                </div>

            </div>
        </div>
    </div>
@endsection




@section('dashboard-datatable-js')
    <!-- jQuery -->
    <script src="{{ asset('dashboard-template/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 (OBLIGATOIRE pour .modal) -->
    <script src="{{ asset('dashboard-template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

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
                "buttons": [
                    // "copy",
                    "csv",
                    // "excel",
                    "pdf",
                    // "print",
                    // "colvis"
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });

        function deleteProduct(i) {
            if (confirm('Voulez-vous supprimer ce produit ??')) {
                $('#form-delete-product' + i).submit();
            }
        }
    </script>
@endsection

@section('dashboard-js')
    <script>
        function openPrintModal(id, name, code) {
            $("#barcode_product_id").val(id);
            $("#barcode_product_code").val(code);
            $("#barcode_product_name").val(name);
            $("#barcode_qty").val(6);
            $("#printBarcodeModal").modal('show');
        }

        // function printBarcode() {
        //     let id = $("#barcode_product_id").val();
        //     let qty = $("#barcode_qty").val();

        //     window.open(`/product/${id}/barcode/pdf?qty=${qty}`, '_blank');

        //     $("#printBarcodeModal").modal('hide');
        // }
        function printBarcode() {
    const id = $("#barcode_product_id").val();
    const qty = parseInt($("#barcode_qty").val(), 10);

    if (!id) {
        alert("Produit non sélectionné");
        return;
    }

    if (!qty || qty <= 0) {
        alert("Quantité invalide");
        return;
    }

    window.open(`/dashboard/product/${id}/barcode/pdf?qty=${qty}`, "_blank");

    $("#printBarcodeModal").modal("hide");
}

    </script>
@endsection
