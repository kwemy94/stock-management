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
    <!-- Hero -->
    <header class="hero mt-5">
        <div class="container">
            <h1>Contactez-nous</h1>
            <p class="lead">Vous avez une question, un projet ou besoin d’assistance ? Écrivez-nous.</p>
        </div>
    </header>

    <!-- Section Contact -->
    <main class="container py-5">
        <div class="row g-4">
            <!-- Formulaire -->
            <div class="col-lg-7">
                <div class="card shadow contact-card p-4">
                    <h4 class="mb-3 text-primary">Envoyez-nous un message</h4>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="name" placeholder="Votre nom">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" class="form-control" id="email" placeholder="exemple@email.com">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="subject" placeholder="Objet du message">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Votre message..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
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
    <script></script>
@endsection
