@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('category.info.new-category') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('category.store') }}" id="create-product-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('product.info.name') }} <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="name" id="name" value="">
                                </div>
        
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control form-control-border border-width-2"
                                        name="description" id="description" value="">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="submit" id="btn-create-category" class="btn btn-primary btn-sm">{{ __('button.save') }}
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
        $('#btn-create-category').click((e) => {
            e.preventDefault();
            if (ControlRequiredFields()) {
                $('#create-product-form').submit();
            }

            console.log('Error');
        });
    </script>
@endsection
