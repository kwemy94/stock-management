@extends('admin.dashboard')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    {{-- Profile Image  --}}
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('dashboard-template/dist/img/user4-128x128.jpg') }}"
                                    alt="User profile picture">
                            </div>

                            {{-- <h3 class="profile-username text-center">Nina Mcintire</h3> --}}

                            {{-- <p class="text-muted text-center">Software Engineer</p> --}}

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>App name</b> <a class="float-right">{{ $setting->app_name }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Téléphone</b> <a class="float-right">{{ $setting->phone }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $setting->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Devise</b> <a class="float-right">{{ $setting->devise }}</a>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>



                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings"
                                        data-toggle="tab">Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="active tab-pane" id="settings">
                                    <form class="form-horizontal" id="setting-form"
                                        action="{{ route('setting.update', $setting->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="inputName"
                                                class="col-sm-2 col-form-label">{{ __('setting.structure-name') }}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control required" name="app_name"
                                                    id="inputName" placeholder="Name" value="{{$setting->app_name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">Téléphone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control required" name="phone"
                                                    id="phone" value="{{$setting->phone}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="devise" class="col-sm-2 col-form-label">Dévise</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control required" name="devise"
                                                    id="devise" value="{{$setting->devise}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control required"
                                                    id="email" placeholder="Email" value="{{$setting->email}}">
                                            </div>
                                        </div>
                                        <div class="input-group row mb-3">
                                            <label for="email" class="col-sm-2 col-form-label">Logo</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" id="btn-setting-save"
                                                    class="btn btn-success btn-sm">{{ __('button.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

        </div>
    </section>
@endsection

@section('dashboard-js')
    <script>
        $('#btn-setting-save').click((e) => {
            e.preventDefault();
            if (ControlRequiredFields()) {
                $('#setting-form').submit();
            }
        });
    </script>
@endsection
