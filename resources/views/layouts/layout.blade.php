<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Street Smart | @yield('title')</title>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ __('home.web-description') }}">
    {{-- <meta name="description" content="site web, application web sur mesure, site vitrine, site carte de visite."> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    {{-- ====== Favicon Icon ====== --}}
    <link rel="shortcut icon" href="{{ asset('front-template/assets/images/favicon-32x32.png') }}" type="image/svg" />
    <link rel="apple-touch-icon" href="{{ asset('front-template/assets/images/logo/logo.png') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f9fafb;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(6px);
        }

        .navbar-custom .nav-link {
            color: #111;
            font-weight: 500;
        }

        .navbar-custom .nav-link.active {
            color: #2563eb;
        }

        .hero {
            background-color: #2563eb;
            color: #fff;
            padding: 5rem 0;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.1rem;
            margin-top: 1rem;
        }

        .hero .btn {
            background: #fff;
            color: #2563eb;
            font-weight: 600;
        }

        .product-card {
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
        }

        .badge-category {
            font-size: .72rem;
        }

        .carousel-item img {
            object-fit: cover;
            height: 420px;
            width: 100%;
        }

        .lang-select {
            min-width: 72px;
            border-radius: .5rem;
        }

        @media (max-width: 576px) {
            .carousel-item img {
                height: 200px;
            }
        }
    </style>
    {{-- sweetalert --}}
    <link rel="stylesheet"
        href="{{ asset('dashboard-template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('front-simpleJs')
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
