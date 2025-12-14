@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content mt-4">
        {{-- @dd($command) --}}
        <div class="container-fluid" id="buy-command-edit" data-command="{{ $command->toJson() }}"></div>

        @viteReactRefresh
        @vite('resources/js/app.js')

    </section>
@endsection

@section('dashboard-js')
    <script></script>
@endsection
