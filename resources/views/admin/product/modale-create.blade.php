<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title h4" style="text-align: center">{{ __('product.new-title') }}</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('product.store') }}" id="product-form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('product.info.name') }} <em>*</em></label>
                            <input type="text" class="form-control form-control-border border-width-2 required"
                                name="name" id="name" placeholder="Ex: Fer de 6">
                        </div>

                        <div class="form-group">
                            <label for="category">Catégorie <em>*</em></label>
                            <select name="category" class="custom-select form-control-border border-width-2 required"
                                id="category">
                                <option value="" disabled >Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="init_stock">{{ __('product.info.qantity-init') }} <em>*</em></label>
                                    <input type="number"
                                        class="form-control form-control-border border-width-2 required"
                                        name="init_stock" id="init_stock" min="0">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="stock_alert">{{ __('product.info.stock-alert') }}</label>
                                    <input type="number" class="form-control form-control-border border-width-2"
                                        name="stock_alert" id="stock_alert" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="unit_price">{{ __('product.info.price') }} <em>*</em></label>
                                    <input type="number"
                                        class="form-control form-control-border border-width-2 required"
                                        name="unit_price" id="unit_price" min="1">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="sale_price">{{ __('product.info.sale-price') }} <em>*</em></label>
                                    <input type="number"
                                        class="form-control form-control-border border-width-2 required"
                                        name="sale_price" id="sale_price" min="1">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control form-control-border border-width-2"
                                name="description" id="description">
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
                        <button type="submit" id="save-product" class="btn btn-primary btn-sm">{{ __('button.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
