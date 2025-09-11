{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Street smart | login</title>


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard-template/dist/css/adminlte.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <a href="#techbriva.com" class="h2"><b>{{ __('login.info-login.title') }} </b> TB</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg h4">{{ __('login.info-login.login') }}</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" name="password" required
                            autocomplete="current-password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock" id="show-pwd"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember_me">
                                <label for="remember">
                                    {{ __('login.info-login.remenber-me') }}
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        
                    </div>
                </form>


                

                <p class="mb-1">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('login.info-login.password-forgot') }}
                        </a>
                    @endif
                </p>
                <p class="mb-0">
                    <a href="#new" class="text-center">{{ __('login.info-login.register') }}</a>
                </p>
            </div>
            
        </div>
        
    </div>
    

    {{-- jQuery --}}
    <script src="{{ asset('dashboard-template/plugins/jquery/jquery.min.js') }}"></script>
    {{-- Bootstrap 4  --}}
    <script src="{{ 'dashboard-template/plugins/bootstrap/js/bootstrap.bundle.min.js' }}"></script>

    <script src="{{ asset('dashboard-template/dist/js/adminlte.min.js') }}"></script>
    <script>
        $('#show-pwd').click( () => {
            let input = $("#password");
    
            $(this).toggleClass("fa-lock fa-unlock");
            input.attr("type", input.attr("type") === "password" ? "text" : "password");
                });
    </script>
</body>

</html>
