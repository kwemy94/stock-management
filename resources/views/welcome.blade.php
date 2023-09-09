@extends('layouts.layout')

@section('front-css')
    <style>
        em {
            color: red;
        }
    </style>
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

@section('front-simpleJs')
    <script>
        $('#btnSubmit').click((e) => {
            // e.preventDefault();

            if (!ControlRequiredFields($('#registerForm .required'))) {
                // alert('echec')
                return;
            }

            $('#btnSubmit').attr('disabled', true);

            let name = $('#app_name').val();
            let phone = $('#app_phone').val();
            let email = $('#app_email').val();
            let logo = $('#app_logo').val();
            let address = $('#app_address').val();
            let activity = $('#app_domain').val();
            let captcha = $('#captcha').val();
            // let _token = $("input[name='_token']").val();
            let datas = {
                name,
                phone,
                email,
                logo,
                address,
                activity,
                captcha
            };
            let url = "{{ route('app.sub.scribt') }}";
            console.log(url);
            postData(url, datas).then(res => {
                console.log(res);
                if (res.success) {
                    $('#registerForm').trigger('reset');
                    $("#supcription_app").modal('hide');
                    alert('Message de confirmation envoyé dans votre boite mail');
                } else {
                    alert('Une erreur survenue. Essayer plus tard');
                    $("#supcription_app").modal('hide');
                }

                $('#btnSubmit').attr('disabled', false);
            }).catch(err => {
                console.log(err.response);
                $('#btnSubmit').attr('disabled', false);
            });
        });
    </script>
@endsection
