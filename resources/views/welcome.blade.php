@extends('layouts.layout')

@section('front-content')
    <!-- ====== Hero Start ====== -->
    @include('partials._home')
    <!-- ====== Hero End ====== -->

    <!-- ====== Features Start ====== -->
    @include('partials._features')
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
