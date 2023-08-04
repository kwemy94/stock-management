<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>2s | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dashboard-template/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="dashboard-template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="dashboard-template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="dashboard-template/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dashboard-template/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="dashboard-template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="dashboard-template/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="dashboard-template/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dashboard-template/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        {{--  Navbar  --}}
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            {{-- Left navbar links  --}}
            @include('layouts.partials._navbar-left')

            {{-- Right navbar links  --}}
            @include('layouts.partials._navbar-right')
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4" style="background-color: rgb(223, 187, 203)">
            <!-- Brand Logo -->
            <a href="{{route('dashboard')}}" class="brand-link">
                <img src="dashboard-template/logo/2s kollect.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Shell Solution</span>
            </a>

            {{-- Sidebar --}}
            @include('layouts.partials._sidebar')

            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">


            {{-- Main content --}}
            @yield('dashboard-content')

        </div>

        {{-- fOOTER --}}
        @include('layouts.partials._footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    {{-- <!-- jQuery --> --}}
    <script src="dashboard-template/plugins/jquery/jquery.min.js"></script>
    {{-- <!-- jQuery UI 1.11.4 --> --}}
    <script src="dashboard-template/plugins/jquery-ui/jquery-ui.min.js"></script>
    {{-- <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --> --}}
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    {{-- <!-- Bootstrap 4 --> --}}
    <script src="dashboard-template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    {{-- <!-- ChartJS --> --}}
    <script src="dashboard-template/plugins/chart.js/Chart.min.js"></script>
    {{-- <!-- Sparkline --> --}}
    <script src="dashboard-template/plugins/sparklines/sparkline.js"></script>
    {{-- <!-- JQVMap --> --}}
    <script src="dashboard-template/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="dashboard-template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    {{-- <!-- jQuery Knob Chart --> --}}
    <script src="dashboard-template/plugins/jquery-knob/jquery.knob.min.js"></script>
    {{-- <!-- daterangepicker --> --}}
    <script src="dashboard-template/plugins/moment/moment.min.js"></script>
    <script src="dashboard-template/plugins/daterangepicker/daterangepicker.js"></script>
    {{-- <!-- Tempusdominus Bootstrap 4 --> --}}
    <script src="dashboard-template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    {{-- <!-- Summernote --> --}}
    <script src="dashboard-template/plugins/summernote/summernote-bs4.min.js"></script>
    
    <script src="dashboard-template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    
    <script src="dashboard-template/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="dashboard-template/dist/js/demo.js"></script> --}}
    
    <script src="dashboard-template/dist/js/pages/dashboard.js"></script>
</body>

</html>
