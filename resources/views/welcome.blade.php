@extends('layouts.layout')

@section('title', 'Accueil')

@section('front-css')
    <style>
        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            display: none;
        }
    </style>
@endsection

@section('front-content')

    <div id="loading">
        <div class="text-center">
            <img src="{{ asset('images/load/preloader.gif') }}" alt="">
            <div class="mt-2" style="font-size: 15px; background: #fff; padding: 6px 15px; border-radius: 12px;">
                {{ __('messages.loader') }}
            </div>
        </div>
    </div>

    <!-- Hero -->
    @include('partials._home')

    <!-- Produits -->
    @include('partials._our-product')

    <!-- About -->
    {{-- @include('partials._about') --}}

    <!-- Team -->
    {{-- @include('partials._team') --}}

    <!-- FAQ -->
    {{-- @include('partials._faq') --}}

    <!-- Contact -->
    {{-- @include('partials._contact') --}}

@endsection


@section('front-simpleJs')
    <script>
        // Soumission formulaire avec animation + toast
        const submitBtn = document.getElementById('btnSubmit');
        if (submitBtn) {
            submitBtn.addEventListener('click', async () => {

                if (!ControlRequiredFields(document.querySelectorAll('#registerForm .required'))) {
                    return;
                }

                document.getElementById('loading').style.display = 'flex';
                submitBtn.disabled = true;

                let datas = {
                    name: document.getElementById('app_name').value,
                    phone: document.getElementById('app_phone').value,
                    email: document.getElementById('app_email').value,
                    logo: document.getElementById('app_logo').value,
                    address: document.getElementById('app_address').value,
                    activity: document.getElementById('app_domain').value,
                };

                try {
                    let response = await fetch("{{ route('app.sub.scribt') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(datas)
                    });

                    let res = await response.json();

                    if (res.success) {
                        document.getElementById('registerForm').reset();
                        toast('success', res.msg);
                        $("#supcription_app").modal('hide');
                    } else {
                        toast('warning', res.msg ?? "Une erreur est survenue.");
                    }
                } catch (err) {
                    toast('error', "Erreur inattendue.");
                }

                document.getElementById('loading').style.display = 'none';
                submitBtn.disabled = false;
            });
        }
    </script>
@endsection
