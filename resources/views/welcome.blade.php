@extends('layouts.layout')

@section('front-css')
    {{-- <link rel="stylesheet" href="{{asset('css/modal.css')}}"> --}}
@endsection

@section('front-content')
    <!-- ====== Hero Start ====== -->
    @include('partials._home')
    <!-- ====== Hero End ====== -->

    <!-- ====== Features Start ====== -->
    @include('partials._our-product')
    <!-- ====== Features End ====== -->

    <!-- ====== About Start ====== -->
    @include('partials._about')
    <!-- ====== About End ====== -->

    <!-- ====== Team Start ====== -->
    @include('partials._team')
    <!-- ====== Team End ====== -->

    <!-- ====== FAQ Start ====== -->
    @include('partials._faq')
    <!-- ====== FAQ End ====== -->

    <!-- ====== Contact Start ====== -->
    @include('partials._contact')
    <!-- ====== Contact End ====== -->


     {{-- Génération de signature pdf --}}
    {{-- <div id="pspdfkit" style="height: 100vh"></div>

    <script src="{{asset('assets/dist/pspdfkit.js')}}"></script>
    <script>
        PSPDFKit.load({
            container: "#pspdfkit",
              document: "document.pdf" // Add the path to your document here.
        })
        .then(function(instance) {
            console.log("PSPDFKit loaded", instance);
        })
        .catch(function(error) {
            console.error(error.message);
        });
    </script> --}}

    
@endsection

@section('front-js')
    {{-- <script src="{{asset('js/modal.js')}}"></script> --}}
@endsection
