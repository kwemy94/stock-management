@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('supplier.title') }} </h3>

                    <div class="card-tools">
                        <a href="{{ route('supplier.create')}}" class="btn btn-outline-success btn-sm"><span class="fa fa-plus"></span> Add</a>
                        {{-- <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                            data-target="#modal-default"><span class="fa fa-plus"></span> Add</button> --}}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ __('supplier.name') }} </th>
                                <th>{{ __('supplier.phone') }} </th>
                                <th>{{ __('Email') }} </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @php
                                $cpte = 1;
                            @endphp

                            @forelse ($suppliers as $supplier)
                                <tr>
                                    <td> {{ $cpte++ }} </td>
                                    <td> {{ $supplier->name }} </td>
                                    <td> {{ $supplier->phone }} </td>
                                    <td> {{ $supplier->email }} </td>
                                    <td>
                                            <form method="post" action="{{route('supplier.destroy',$supplier->id)}}" id="form-delete-supplier{{$supplier->id}}">
                                                
                                                <a href="{{route('supplier.edit', $supplier->id)}}" class="fas fa-pen-alt"
                                                    style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                                @csrf
                                                @method('delete')
                                                <span  id="btn-delete-supplier{{$supplier->id}}" onclick="deletesupplier({{$supplier->id}})"  class="fas fa-trash-alt" style="color: red"></span>
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
                <div class="card-footer">
                    <div class="card-tools">
                        <ul class="pagination pagination-sm float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection


@section('dashboard-js')
    <script>
        // $('#btn-delete-supplier').click( () =>{
        //     if (confirm('Voulez-vous supprimer cette catégory ??')) {
        //         $('#form-delete-supplier').submit();
        //     }
        // });

        function deletesupplier(i) {
            if (confirm('Voulez-vous supprimer ce fournisseur??')) {
                $('#form-delete-supplier'+i).submit();
            }
        }

        $('#save-supplier').click((e) => {
            e.preventDefault();
            let url = "{{ route('supplier.store') }}";
            let datas = {
                name: $('#name').val(),
                description: $('#description').val(),
            }

            console.log('Error');
        });
    </script>
@endsection
