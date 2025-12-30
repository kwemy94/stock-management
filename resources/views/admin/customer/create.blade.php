@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">

                <div class="col-md-6">

                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-plus mr-1"></i>
                                {{ __('Nouveau client') }}
                            </h3>
                        </div>

                        <form method="POST" action="{{ route('customer.store') }}" id="customer-form">
                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label>{{ __('Nom client') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-sm required" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Téléphone') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control form-control-sm required" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('CNI') }}</label>
                                    <input type="text" name="cni" class="form-control form-control-sm">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control form-control-sm">
                                </div>

                                <div class="form-group mb-0">
                                    <label>{{ __('Adresse') }}</label>
                                    <input type="text" name="adress" class="form-control form-control-sm">
                                </div>

                            </div>

                            <div class="card-footer text-right bg-white">
                                <button type="submit" class="btn btn-primary btn-sm" id="save-customer">
                                    <i class="fas fa-save mr-1"></i>
                                    {{ __('button.save') }}
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
        $('#save-customer').click((e) => {
            e.preventDefault();
            if (ControlRequiredFields()) {
                $('#customer-form').submit()
            }
        });
    </script>
@endsection
