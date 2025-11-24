@extends('layouts.layout')

@section('front-css')
    {{-- <link rel="stylesheet" href="{{ asset('css/intlTelInput.css') }}"> --}}
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

        .error-field {
            border: 1px solid #dc3545 !important;
            background-color: #fff5f5;
        }
    </style>
@endsection

@section('front-content')
    <!-- Hero -->
    <header class="hero mt-5">
        <div class="container">
            <h1>Contactez-nous</h1>
            <p class="lead">Vous avez une question, un projet ou besoin d’assistance ? Écrivez-nous.</p>
        </div>
    </header>

    <!-- Section Contact -->
    <main class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Succès !</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erreur !</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Formulaire -->
            <div class="col-lg-7">
                <div class="card shadow contact-card p-4">
                    <h4 class="mb-3 text-primary">Envoyez-nous un message</h4>
                    <form action="{{ route('contact.us.message') }}" method="POST" id="formContact">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control required" name="name" placeholder="Votre nom">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Numéro de téléphone</label>
                            <input type="tel" class="form-control required" id="phone" name="phone">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="phone" class="form-label">Numéro de téléphone</label>
                            <input type="tel" class="form-control required" id="phone" name="phone">
                            <input type="hidden" name="phone_full" id="phone_full">
                        </div> --}}

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" class="form-control required" name="email"
                                placeholder="exemple@email.com">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control required" name="subject"
                                placeholder="Objet du message">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control required" name="message" rows="5" placeholder="Votre message..."></textarea>
                        </div>
                        {{-- <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            @if ($errors->has('captcha'))
                                <span class="text-danger">{{ $errors->first('captcha') }}</span>
                            @endif

                        </div> --}}

                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-sm">Envoyer</button>
                    </form>
                </div>
            </div>

            <!-- Coordonnées -->
            <div class="col-lg-5">
                <div class="contact-info p-4 shadow">
                    <h4 class="mb-3">Nos coordonnées</h4>
                    <p><strong>Email :</strong> contact@techbrivi.com</p>
                    <p><strong>Téléphone :</strong> +237 6 89 86 12 26</p>
                    <p><strong>Adresse :</strong> Yaoundé, Cameroun</p>
                </div>
                <div class="mt-4 shadow rounded overflow-hidden">
                    <!-- Google Map intégrée -->
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3975.575...etc" width="100%"
                        height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
                </div>
            </div>
        </div>
    </main>
@endsection

@section('front-simpleJs')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.querySelector("#phone");

            const iti = window.intlTelInput(input, {
                initialCountry: "cm", // Cameroun par défaut
                separateDialCode: true,
                preferredCountries: ["cm", "fr", "us", "gb"],
                utilsScript: "{{ asset('js/utils.js') }}"
            });

            // On met le numéro complet dans le champ hidden
            input.addEventListener("blur", function() {
                if (iti.isValidNumber()) {
                    document.querySelector('#phone_full').value = iti.getNumber();
                } else {
                    alert("Numéro invalide !");
                }
            });
        });
    </script> --}}
    <script>
        $("#btnSubmit").on("click", function(e) {
            e.preventDefault();
            if (!ControlRequiredFields($("#formContact .required"))) {
                return;

            }
            $("#loading").show();
            $("#btnSubmit").prop("disabled", true);
            $("#formContact").submit();
        });
    </script>
@endsection
