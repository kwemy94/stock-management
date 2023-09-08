<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tech Briva | @yield('title')</title>

    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{__('home.web-description')}}">
    {{-- <meta name="description" content="site web, application web sur mesure, site vitrine, site carte de visite."> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    {{-- ====== Favicon Icon ====== --}}
    <link rel="shortcut icon" href="{{ asset('front-template/assets/images/favicon-32x32.png') }}" type="image/svg" />
    <link rel="apple-touch-icon" href="{{asset('front-template/assets/images/logo/logo.png')}}">

    <!-- ===== All CSS files ===== -->
    <link rel="stylesheet" href="{{ asset('front-template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-template/assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-template/assets/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-template/assets/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-template/assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-template/assets/css/about.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/_contact.css')}}">

    @yield('front-css')

</head>

<body>
    <!-- ====== Header Start ====== -->
    @include('layouts.partials._header')
    <!-- ====== Header End ====== -->

    @yield('front-content')

    <!-- ====== Footer Start ====== -->
    @include('layouts.partials._footer')
    <!-- ====== Footer End ====== -->

    <!-- ====== Back To Top Start ====== -->
    <a href="javascript:void(0)" class="back-to-top">
        <i class="lni lni-chevron-up"> </i>
    </a>
    <!-- ====== Back To Top End ====== -->

    <!-- ====== All Javascript Files ====== -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('front-template/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('front-template/assets/js/wow.min.js')}}"></script>
    <script src="{{ asset('front-template/assets/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('front-template/assets/js/main.js')}}"></script>
    <script src="{{ asset('js/custom.js')}}"></script>

    {{-- Traduction du site --}}
    <script type="text/javascript">
        var url = "{{ route('change-lang') }}";
        $(".Langchange").change(function() {
            console.log('Loading...');
            window.location.href = url + "?lang=" + $(this).val();
        });

        // Region captcha
        $(".btn-refresh").click(function() {
            $.ajax({
                type: 'GET',
                url: '/refresh_captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
    @yield('front-js')
</body>

</html>
