@extends('layouts.layout')

@section('front-css')
    <style>
        em {
            color: red;
        }

        .subscribe {
            border: none;
            border-bottom: 1px solid black;
        }

        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            z-index: 99999;
        }
    </style>
@endsection

@section('front-content')
    <div class="submit-loading-table col-md-12 text-center" style="display: none;" id="loading">
        <img src="{{ asset('images/load/preloader.gif') }}" alt="">
        <div class="text-center">
            <span
                style="font-size: 16px; background-color: #ffffff; border-radius: 15px;
            padding: 5px 10px 5px 10px;">
                {{ __('messages.loader') }}
            </span>
        </div>
    </div>
    <!-- ====== Hero Start ====== -->
    @include('partials._home')
    <!-- ====== Hero End ====== -->

    <!-- ====== Features Start ====== -->
    @include('partials._our-product')
    <!-- ====== Features End ====== -->

    <!-- ====== About Start ====== -->
    {{-- @include('partials._about') --}}
    <!-- ====== About End ====== -->

    <!-- ====== Team Start ====== -->
    {{-- @include('partials._team') --}}
    <!-- ====== Team End ====== -->

    <!-- ====== FAQ Start ====== -->
    {{-- @include('partials._faq') --}}
    <!-- ====== FAQ End ====== -->

    <!-- ====== Contact Start ====== -->
    {{-- @include('partials._contact') --}}
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
        // $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
        // })
        $('#lapin').click(function() {
            Toast.fire({
                icon: 'success',
                title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
            })
        });

        $('#btnSubmit').click((e) => {
            // e.preventDefault();

            if (!ControlRequiredFields($('#registerForm .required'))) {
                return;
            }
            $('#loading').css('display', 'block');

            $('#btnSubmit').prop('disabled', true);

            let name = $('#app_name').val();
            let phone = $('#app_phone').val();
            let email = $('#app_email').val();
            let logo = $('#app_logo').val();
            let address = $('#app_address').val();
            let activity = $('#app_domain').val();
            //let captcha = $('#captcha').val();
            // let _token = $("input[name='_token']").val();
            let datas = {
                name,
                phone,
                email,
                logo,
                address,
                activity,
                // captcha
            };
            let url = "{{ route('app.sub.scribt') }}";
            console.log(url);
            postData(url, datas).then(res => {
                console.log(res);
                if (res.success) {
                    $('#registerForm').trigger('reset');
                    $("#supcription_app").modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: res.msg
                    });
                } else {
                    let msg = "Une erreur survenue! Essayer plus tard.";
                    if (res.msg)
                        msg = res.msg;

                    Toast.fire({
                        icon: 'warning',
                        title: msg
                    })
                    $("#supcription_app").modal('hide');
                }
                $('#loading').css('display', 'none');
                $('#btnSubmit').prop('disabled', false);
            }).catch(err => {
                console.log(err.response);
                $('#loading').css('display', 'none');
                $('#btnSubmit').prop('disabled', false);
                Toast.fire({
                    icon: 'error',
                    title: 'Oups!! Erreur survenue'
                })
            });
        });
        // })
    </script>
@endsection
