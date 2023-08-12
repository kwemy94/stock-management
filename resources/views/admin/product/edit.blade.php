@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('product.new-title') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('product.update', $product->id) }}" id="update-product-form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('product.info.name') }} <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="product_name" id="name" value="{{$product->product_name}}">
                                </div>
        
                                <div class="form-group">
                                    <label for="category">Catégorie <em>*</em></label>
                                    <select name="category_id" class="custom-select form-control-border border-width-2 required"
                                        id="category">
                                        <option value="" disabled >Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{$category->id == $product->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="init_stock">{{ __('product.info.qantity-init') }} <em>*</em></label>
                                            <input type="number"
                                                class="form-control form-control-border border-width-2 required"
                                                name="stock_quantity" id="init_stock" min="0" value="{{$product->stock_quantity}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="stock_alert">{{ __('product.info.stock-alert') }}</label>
                                            <input type="number" class="form-control form-control-border border-width-2"
                                                name="stock_alert" id="stock_alert" min="0" value="{{$product->stock_alert}}">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="unit_price">{{ __('product.info.price') }} <em>*</em></label>
                                            <input type="number"
                                                class="form-control form-control-border border-width-2 required"
                                                name="unit_price" id="unit_price" min="1" value="{{$product->unit_price}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="sale_price">{{ __('product.info.sale-price') }} <em>*</em></label>
                                            <input type="number"
                                                class="form-control form-control-border border-width-2 required"
                                                name="sale_price" id="sale_price" min="1" value="{{$product->sale_price}}">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control form-control-border border-width-2"
                                        name="description" id="description" value="{{$product->description}}">
                                </div>
        
                                <div class="form-group">
                                    <label for="product_image">{{ __('product.info.product-image') }}</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="product_image"
                                                name="product_image">
                                            <label class="custom-file-label"
                                                for="exampleInputFile">{{ __('button.placeholder-file') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="modal-footer justify-content-between">
                                <button type="submit" id="btn-update-product" class="btn btn-primary btn-sm">{{ __('button.save') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('dashboard-js')
    <script>
        $('#save-product').click((e) => {
            e.preventDefault();
            if (ControlRequiredFields()) {
                $('#product-form').submit();
            }

            console.log('Error');
        });
    </script>
@endsection
