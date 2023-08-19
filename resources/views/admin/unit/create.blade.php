@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>

                <div class="col-md-6"> 

                    <div class="card card-primary">
                        <div class="card-header" style="background-color: rgb(32, 47, 112)">
                            @if (isset($unit))
                            <h3 class="card-title">{{ __('Modification unité de mesure') }}</h3>
                            @else
                            <h3 class="card-title">{{ __('Nouvelle unité de mesure') }}</h3>
                            @endif
                            
                        </div>

                        @if (isset($unit))
                        <form method="POST" action="{{ route('unite-mesure.update', $unit->id)}}" id="unit-form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        @else
                        <form method="POST" action="{{ route('unite-mesure.store') }}" id="unit-form" enctype="multipart/form-data">
                            @csrf
                        @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('Unité') }} <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="name" id="name" value="{{isset($unit)? $unit->name : ''}}" placeholder="Ex: Pièce">
                                </div>
        
                                
                            </div>
        
                            <div class="modal-footer justify-content-between">
                                <button type="submit" id="save-unit" class="btn btn-primary btn-sm">{{ __('button.save') }}
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

        $('#save-unit').click((e) => {
            e.preventDefault();
            if(ControlRequiredFields()){
                $('#unit-form').submit()
            }
        });
    </script>
@endsection
