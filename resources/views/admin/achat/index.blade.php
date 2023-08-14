@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Liste approvisionnement') }} </h3>

                    <div class="card-tools">
                        <a href="{{ route('achat.create') }}" class="btn btn-outline-success btn-sm"><span
                                class="fa fa-plus"></span> Add</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
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

        function deleteachat(i) {
            if (confirm('Voulez-vous supprimer cet approvisionnement ??')) {
                $('#form-delete-achat' + i).submit();
            }
        }

        $('#save-achat').click((e) => {
            e.preventDefault();
            let url = "{{ route('achat.store') }}";
            let datas = {
                name: $('#name').val(),
                description: $('#description').val(),
            }

            console.log('Error');
        });
    </script>
@endsection
