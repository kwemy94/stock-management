@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid" id="buy-invoice"></div>

        @viteReactRefresh
        @vite('resources/js/app.js')

    </section>
@endsection

@section('dashboard-js')
    <script></script>
@endsection
