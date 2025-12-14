<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Street Smart | @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ __('home.web-description') }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('front-template/assets/images/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('front-template/assets/images/logo/logo.png') }}">

    <!-- Google Font (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert Theme -->
    <link rel="stylesheet"
        href="{{ asset('dashboard-template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!-- Style Global Modernisé -->
    <style>
        :root {
            --primary: #2563eb;
            --dark: #111;
            --light: #f9fafb;
            --radius: .75rem;
        }

        body {
            background: var(--light);
            font-family: "Inter", sans-serif;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, .75);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, .05);
        }

        .navbar-custom .nav-link {
            color: var(--dark);
            font-weight: 500;
        }

        .navbar-custom .nav-link.active {
            color: var(--primary) !important;
        }

        /* Hero */
        .hero {
            background: var(--primary);
            padding: 5rem 0;
            color: #fff;
        }

        .hero h1 {
            font-size: 2.6rem;
            font-weight: 700;
        }

        /* Cards */
        .product-card {
            background: #fff;
            border-radius: var(--radius);
            transition: .25s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, .12);
        }

        /* Carousel */
        .carousel-item img {
            object-fit: cover;
            height: 420px;
            width: 100%;
        }

        @media(max-width: 576px) {
            .carousel-item img {
                height: 220px;
            }
        }

        .section {
            padding: 5rem 0;
        }
    </style>

    @yield('front-css')
</head>

<body>

    @include('layouts.partials._header')

    @yield('front-content')

    @include('layouts.partials._footer')

    <!-- Back to top -->
    <a href="javascript:void(0)" class="back-to-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Helper global Toast
        window.toast = (icon, title) => {
            Swal.fire({
                toast: true,
                icon,
                title,
                position: "top-end",
                showConfirmButton: false,
                timer: 4000,
            });
        };

        // Language switch
        document.querySelectorAll('.Langchange').forEach(el => {
            el.addEventListener('change', e => {
                window.location.href = "{{ route('change-lang') }}?lang=" + e.target.value;
            });
        });

        // Refresh captcha
        document.addEventListener("click", (e) => {
            if (!e.target.classList.contains("btn-refresh")) return;
            fetch('/refresh_captcha')
                .then(res => res.json())
                .then(data => {
                    document.querySelector(".captcha span").innerHTML = data.captcha;
                });
        });
    </script>

    @yield('front-js')

</body>

</html>
