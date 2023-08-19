@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>

                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header" style="background-color: rgb(32, 47, 112)">
                            <h3 class="card-title">{{ __('Nouveau client') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('customer.store') }}" id="customer-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('Nom client') }} <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="name" id="name" placeholder="Ex: Fer de 6">
                                </div>
                                <div class="form-group">
                                    <label for="cni">{{ __('CNI') }} <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2"
                                        name="cni" id="name">
                                </div>
        
                                <div class="form-group">
                                    <label for="phone">Téléphone</label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="phone" id="phone">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control form-control-border border-width-2"
                                        name="email" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="adress">Adresse</label>
                                    <input type="text" class="form-control form-control-border border-width-2"
                                        name="adress" id="adress">
                                </div>
                            </div>
        
                            <div class="modal-footer justify-content-between">
                                <button type="submit" id="save-customer" class="btn btn-primary btn-sm">{{ __('button.save') }}
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

        $('#save-customer').click((e) => {
            e.preventDefault();
            if(ControlRequiredFields()){
                $('#customer-form').submit()
            }
        });
    </script>
@endsection
