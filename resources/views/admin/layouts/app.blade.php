<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tech briva| Dashboard</title>

    <link rel="shortcut icon" href="{{ asset('front-template/assets/images/favicon-32x32.png') }}" type="image/svg" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('dashboard-template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('dashboard-template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/summernote/summernote-bs4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
    @yield('dashboard-datatable-css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('front-template/assets/images/logo/logo.png') }}"
                alt="Tech briva" height="60" width="60" style="border-radius: 50px;">
        </div>

        {{--  Navbar  --}}
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: rgb(32, 47, 112)">
            {{-- Left navbar links  --}}
            @include('admin.layouts.partials._navbar-left')

            {{-- Right navbar links  --}}
            @include('admin.layouts.partials._navbar-right')
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4" style="background-color: rgba(20, 29, 70, 1)">


            {{-- Sidebar --}}
            @include('admin.layouts.partials._sidebar')

            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>


            {{-- Main content --}}
            @yield('dashboard-content')

        </div>

        {{-- fOOTER --}}
        @include('admin.layouts.partials._footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    {{-- <!-- jQuery --> --}}
    <script src="{{ asset('dashboard-template/plugins/jquery/jquery.min.js') }}"></script>
    {{-- <!-- jQuery UI 1.11.4 --> --}}
    <script src="{{ asset('dashboard-template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    {{-- <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --> --}}
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    {{-- <!-- Bootstrap 4 --> --}}
    <script src="{{ asset('dashboard-template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <!-- ChartJS --> --}}
    <script src="{{ asset('dashboard-template/plugins/chart.js/Chart.min.js') }}"></script>
    {{-- <!-- Sparkline --> --}}
    <script src="{{ asset('dashboard-template/plugins/sparklines/sparkline.js') }}"></script>
    {{-- <!-- JQVMap --> --}}
    <script src="{{ asset('dashboard-template/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    {{-- <!-- jQuery Knob Chart --> --}}
    <script src="{{ asset('dashboard-template/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    {{-- <!-- daterangepicker --> --}}
    <script src="{{ asset('dashboard-template/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/daterangepicker/daterangepicker.js') }}"></script>
    {{-- <!-- Tempusdominus Bootstrap 4 --> --}}
    <script src="{{ asset('dashboard-template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    {{-- <!-- Summernote --> --}}
    <script src="{{ asset('dashboard-template/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('dashboard-template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <script src="{{ asset('dashboard-template/dist/js/adminlte.js') }}"></script>

    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('dashboard-js')
    @yield('dashboard-datatable-js')

    <script src="{{ asset('dashboard-template/dist/js/pages/dashboard.js') }}"></script>
    <script type="text/javascript">
        var url = "{{ route('change-lang') }}";
        $(".Langchange").change(function() {
            window.location.href = url + "?lang=" + $(this).val();
        });
    </script>
</body>

</html>
