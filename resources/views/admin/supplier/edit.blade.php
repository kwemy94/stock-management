@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('supplier.info.edit-supplier') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('supplier.update', $supplier->id) }}" id="create-supplier-form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('supplier.name') }} <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="name" value="{{$supplier->name}}" id="name" value="">
                                </div>

                                <div class="form-group">
                                    <label for="phone">{{ __('supplier.phone') }}</label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="phone" value="{{$supplier->phone}}" id="phone" value="">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control form-control-border border-width-2 required"
                                        name="email" value="{{$supplier->email}}" id="email" value="">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="submit" id="btn-create-supplier"
                                    class="btn btn-primary btn-sm">{{ __('button.save') }}
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
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $('#btn-create-supplier').click((e) => {
            e.preventDefault();
            if (ControlRequiredFields()) {
                $('#create-supplier-form').submit();
            }

            console.log('Error');
        });
    </script>
@endsection
