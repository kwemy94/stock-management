<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Licence requise | StreetSmart</title>

    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-template/dist/css/adminlte.min.css') }}">

    <style>
        body {
            background-color: #f4f6f9;
        }
    </style>
</head>

<body>

    {{-- MODAL BLOQUANTE --}}
    <div class="modal fade show" id="licenseExpiredModal" tabindex="-1" style="display:block;" data-backdrop="static"
        data-keyboard="false">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">

                {{-- HEADER --}}
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-lock"></i> Licence requise
                    </h5>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- BODY --}}
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        Votre licence StreetSmart est <strong>invalide ou expirée</strong>.
                        Veuillez entrer une clé de licence valide pour continuer.
                    </p>

                    {{-- FORMULAIRE CLE LICENCE --}}
                    <form method="POST" action="{{ route('licenses.activate') }}">
                        @csrf

                        <div class="form-group">
                            <label>Clé de licence</label>
                            <input type="text" name="license_key"
                                class="form-control @error('license_key') is-invalid @enderror"
                                placeholder="SS-XXXXXXXXXXXX" required>
                            @error('license_key')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-key"></i> Activer la licence
                        </button>
                    </form>
                </div>

                {{-- FOOTER --}}
                <div class="modal-footer justify-content-between bg-light">
                    <span class="text-muted small">
                        Accès bloqué sans licence valide
                    </span>

                    {{-- BOUTON QUITTER --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Quitter
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- BACKDROP FORCE --}}
    <div class="modal-backdrop fade show"></div>

    <script src="{{ asset('dashboard-template/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Faire disparaire l'alerte
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3500);
    </script>
</body>

</html>
