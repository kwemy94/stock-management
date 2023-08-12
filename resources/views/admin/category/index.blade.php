@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('category.title') }} </h3>

                    <div class="card-tools">
                        <a href="{{ route('category.create')}}" class="btn btn-outline-success btn-sm"><span class="fa fa-plus"></span> Add</a>
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
                                <th>{{ __('category.name') }} </th>
                                <th>{{ __('Description') }} </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @php
                                $cpte = 1;
                            @endphp

                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $cpte++ }}</td>
                                    <td>{{ $category->name }} </td>
                                    <td>
                                        {{ $category->description }}
                                    </td>
                                    <td>
                                        <a href="{{ route('category.show', $category->id)}}" class="fas fa-eye" style="color: green"></a>
                                        <a href="{{route('category.edit', $category->id)}}" class="fas fa-pen-alt"
                                            style="color: #217fff; margin-left: 5px; margin-right: 5px;"></a>
                                            <form method="post" action="{{route('category.destroy',$category->id)}}" id="form-delete-category{{$category->id}}">
                                                @method('delete')
                                                @csrf
                                                <span  id="btn-delete-category{{$category->id}}" onclick="deleteCategory({{$category->id}})"  class="fas fa-trash-alt" style="color: red"></span>
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
        // $('#btn-delete-category').click( () =>{
        //     if (confirm('Voulez-vous supprimer cette catégory ??')) {
        //         $('#form-delete-category').submit();
        //     }
        // });

        function deleteCategory(i) {
            if (confirm('Voulez-vous supprimer cette catégory ??')) {
                $('#form-delete-category'+i).submit();
            }
        }

        $('#save-category').click((e) => {
            e.preventDefault();
            let url = "{{ route('category.store') }}";
            let datas = {
                name: $('#name').val(),
                description: $('#description').val(),
            }

            console.log('Error');
        });
    </script>
@endsection
