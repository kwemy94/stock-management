<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Accès refusé</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap (si déjà chargé globalement, tu peux retirer) --}}
    <link rel="stylesheet" href="{{ asset('front-template/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/fontawesome-free/css/all.min.css') }}">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .error-container {
            min-height: 100vh;
        }

        .error-card {
            border: none;
            border-radius: 8px;
        }

        .error-icon {
            font-size: 64px;
            color: #dc3545;
        }
    </style>
</head>

<body>

    <div class="container error-container d-flex align-items-center justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm error-card text-center">
                <div class="card-body p-4">

                    <div class="mb-3">
                        <i class="fas fa-ban error-icon"></i>
                    </div>

                    <h3 class="mb-2">Accès refusé</h3>

                    <p class="text-muted mb-4">
                        Vous n’avez pas les permissions nécessaires pour accéder à cette page.
                    </p>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-2 btn">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Retour
                        </a>

                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-home mr-1"></i>
                            Tableau de bord
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
