<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Création de votre compte</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f6f6f6;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 25px;
            border-radius: 6px;
        }

        h2 {
            color: #2c3e50;
        }

        p {
            color: #444;
            line-height: 1.6;
        }

        .credentials {
            background-color: #f2f2f2;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            background-color: #3490dc;
            color: #ffffff !important;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Bienvenue {{ $data['name'] ?? '' }},</h2>

        <p>
            Votre compte a été créé avec succès. Vous pouvez dès à présent vous connecter
            à la plateforme en utilisant les identifiants ci-dessous :
        </p>

        <div class="credentials">
            <p><strong>Login :</strong> {{ $data['email'] }}</p>
            <p><strong>Mot de passe :</strong> {{ $data['pwd'] }}</p>
        </div>

        <p>
            Pour accéder à votre espace, cliquez sur le bouton ci-dessous :
        </p>

        <p style="text-align: center;">
            <a href="{{ route('login') }}" class="btn">
                Se connecter
            </a>
        </p>

        <p>
            Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe
            dès votre première connexion.
        </p>

        <div class="footer">
            <p>
                Si vous n’êtes pas à l’origine de cette création de compte, veuillez contacter
                l’administrateur immédiatement.
            </p>
            <p>
                © {{ date('Y') }} {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>

</html>
