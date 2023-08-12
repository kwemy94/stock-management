@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">{{ $product->product_name }}</h3>
                        <div class="col-12">
                            <img src="{{ asset('dashboard-template/dist/img/prod-1.jpg') }}" class="product-image"
                                alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <div class="product-image-thumb active"><img
                                    src="{{ asset('dashboard-template/dist/img/prod-1.jpg') }}" alt="Product Image"></div>
                            <div class="product-image-thumb"><img
                                    src="{{ asset('dashboard-template/dist/img/prod-2.jpg') }}" alt="Product Image"></div>
                            <div class="product-image-thumb"><img
                                    src="{{ asset('dashboard-template/dist/img/prod-3.jpg') }}" alt="Product Image"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">{{ $product->product_name }}</h3>

                        <hr>
                        <h4>Information sur le produit</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-default text-center active">
                                <input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
                                {{ __('product.info.qantity') }}
                                <br>
                                <i class=" text-green">{{ $product->stock_quantity }} </i>
                            </label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option_a2" autocomplete="off">
                                {{ __('product.info.qantity-available') }}
                                <br>
                                <i class=" text-blue">xxx </i>
                            </label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option_a3" autocomplete="off">
                                {{ __('product.info.price') }}
                                <br>
                                <i class="text-purple">{{ $product->unit_price }} </i>
                            </label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option_a4" autocomplete="off">
                                {{ __('product.info.sale-price') }}
                                <br>
                                <i class="text-red">{{ $product->sale_price }}</i>
                            </label>

                        </div>

                        <div class="btn-group btn-group-toggle mt-4">
                            <a class="btn btn-primary btn-sm" href="{{ route('product.edit', $product->id) }}">Modifier</a>
                        </div>

                    </div>
                </div>
                <div class="row mt-4">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc"
                                role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                            <a class="nav-item nav-link" id="product-others-tab" data-toggle="tab" href="#product-others"
                                role="tab" aria-controls="product-others" aria-selected="false">Other</a>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                            aria-labelledby="product-desc-tab">
                            {{ $product->description }}
                        </div>
                        <div class="tab-pane fade" id="product-others" role="tabpanel" aria-labelledby="product-others-tab">
                            RAS other
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection

@section('dashboard-js')
    <script>
        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
    </script>
@endsection
