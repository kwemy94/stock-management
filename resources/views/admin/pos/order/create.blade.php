@extends('admin.dashboard')

@section('dashboard-content')
    <section class="content mt-4">
        <div class="container-fluid" id="pos" ></div>

        @viteReactRefresh
        @vite('resources/js/app.js')
    </section>
@endsection
