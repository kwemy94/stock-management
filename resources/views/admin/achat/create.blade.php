@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>

                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header" style="background-color: rgb(32, 47, 112)">
                            <h3 class="card-title">{{ __('Approvisionnement') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('achat.store') }}" id="achat-form">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="product">Produit <em>*</em></label>
                                    <select name="product_id"
                                        class="custom-select form-control-border border-width-2 required" id="product">
                                        <option value="" disabled selected>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="supplier">Fournisseur <em>*</em></label>
                                    <select name="supplier_id"
                                        class="custom-select form-control-border border-width-2 required" id="supplier">
                                        <option value="" disabled selected>Select fournisseur</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">{{ __('product.info.qantity') }} <em>*</em></label>
                                    <input type="number" class="form-control form-control-border border-width-2 required"
                                        name="quantity" id="quantity" min="1">
                                </div>

                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="submit" id="save-achat"
                                    class="btn btn-primary btn-sm">{{ __('button.save') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="col-md-3"></div>
            </div>
        </div>
    </section>
@endsection

@section('dashboard-js')
    <script>
        $('#save-achat').click((e) => {
            e.preventDefault();
            console.log($('#supplier').val());
            if (ControlRequiredFields()) {
                $('#achat-form').submit()
            }
        });
    </script>
@endsection
