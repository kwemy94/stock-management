@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                                        href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                                        aria-selected="true">Devis</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-three-profile" role="tab"
                                        aria-controls="custom-tabs-three-profile" aria-selected="false">Commande</a>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-three-home-tab">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus
                                    ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna
                                    feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula.
                                    Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque
                                    habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin
                                    id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim
                                    sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor
                                    porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non
                                    consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus.
                                    Cras lacinia erat eget sapien porta consectetur.
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-three-profile-tab">
                                    <section class="content mt-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">{{ __('Liste des unités de mesure') }}</h3>
                                                            <div class="card-tools">
                                                                <a href="{{ route('unite-mesure.create')}}" class="btn btn-outline-success btn-sm"><span class="fa fa-plus"></span> Add</a>
                                                             </div>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <table id="example1" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10px">#</th>
                                                                        <th>{{ __('Unité de mesure') }} </th>
                                                                        <th>{{ __('Unité de mesure') }} </th>
                                                                        <th>{{ __('Unité de mesure') }} </th>
                                                                        <th>{{ __('Unité de mesure') }} </th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $cpt = 1;
                                                                    @endphp
                                                                    @forelse ($sales as $sale)
                                                                        <tr>
                                                                            <td>{{ $cpt++ }}</td>
                                                                            <td>XXXX </td>
                                                                            <td>XXXX </td>
                                                                            <td>XXXX </td>
                                                                            <td>XXXX </td>
                                
                                                                            <td style="display: flex !important;">
                                                                                
                                                                                <form method="post" action="{{ route('unite-mesure.destroy', 1) }}"
                                                                                    id="form-delete-unit{{-- $unit->id --}}">
                                                                                    <a href="{{-- route('unite-mesure.edit', $unit->id) --}}" class="fas fa-pen-alt"
                                                                                        style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                                                                    <a href="#" title="expedier"></a>
                                                                                    <a href="#" title="valider"></a>
                                                                                    <a href="#" title="valider & expédier"></a>
                                                                                        
                                                                                    @csrf
                                                                                    @method('delete')
                                                                                    <span id="btn-delete-unit{{-- $unit->id --}}"
                                                                                        onclick="deleteUnit({{-- $unit->id --}})"
                                                                                        class="fas fa-trash-alt" style="color: rgb(248, 38, 38)"></span>
                                
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
                                                                        <th>{{ __('Unité de mesure ') }} </th>
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
                                </div>
                                
                            </div>
                        </div>
                        <!-- /.card -->
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

        function deleteUnit(i) {
            if (confirm('Voulez-vous supprimer cette unité ??')) {
                $('#form-delete-unit' + i).submit();
            }
        }
    </script>
@endsection