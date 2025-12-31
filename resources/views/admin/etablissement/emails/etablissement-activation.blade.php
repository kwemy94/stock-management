<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <h2>Bienvenue {{ $etablissement->name }}</h2>

    <p>
        Votre environnement est prêt.
        Veuillez cliquer sur le bouton ci-dessous pour activer votre compte administrateur.
    </p>

    <p>
        <a href="{{ $activationUrl }}"
            style="background:#0d6efd;color:#fff;padding:10px 15px;text-decoration:none;border-radius:4px;">
            Activer mon compte
        </a>
    </p>

    <p>
        Si vous n’êtes pas à l’origine de cette demande, ignorez ce message.
    </p>

    <hr>
    <small>{{ config('app.name') }}</small>
</body>

</html>
