@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>

                {{-- <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header" style="background-color: rgb(32, 47, 112)">
                            <h3 class="card-title">{{ __('Modification info client') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('customer.update', $customer->id) }}" id="customer-form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('Nom client') }} <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="name" id="name" value="{{$customer->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="cni">{{ __('CNI') }} <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2"
                                        name="cni" id="cni" value="{{$customer->cni}}">
                                </div>
        
                                <div class="form-group">
                                    <label for="phone">Téléphone</label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="phone" id="phone" value="{{$customer->phone}}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control form-control-border border-width-2"
                                        name="email" id="email" value="{{$customer->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="adress">Adresse</label>
                                    <input type="text" class="form-control form-control-border border-width-2"
                                        name="adress" id="adress" value="{{$customer->adress}}">
                                </div>
                            </div>
        
                            <div class="modal-footer justify-content-between">
                                <button type="submit" id="save-customer" class="btn btn-primary btn-sm">{{ __('button.save') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div> --}}


                <div class="col-md-3"></div>
            </div>

            <div class="row justify-content-center">

                <div class="col-md-6">

                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-plus mr-1"></i>
                                {{ __('Modification info client') }}
                            </h3>
                        </div>

                        <form method="POST" action="{{ route('customer.update', $customer->id) }}" id="customer-form">
                            @csrf

                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label>{{ __('Nom client') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{$customer->name}}" class="form-control form-control-sm required" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Téléphone') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" value="{{$customer->phone}}" class="form-control form-control-sm required" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('CNI') }}</label>
                                    <input type="text" name="cni" value="{{$customer->cni}}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{$customer->email}}" class="form-control form-control-sm">
                                </div>

                                <div class="form-group mb-0">
                                    <label>{{ __('Adresse') }}</label>
                                    <input type="text" name="adress" value="{{$customer->adress}}" class="form-control form-control-sm">
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
            if(ControlRequiredFields()){
                $('#customer-form').submit()
            }
        });
    </script>
@endsection
