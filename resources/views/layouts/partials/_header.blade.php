<nav class="navbar navbar-expand-lg navbar-light navbar-custom shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">Street Smart</a>
        {{-- <a class="navbar-brand" href="index.html">
            <img src="{{ asset('front-template/assets/images/logo/logo.png') }}" alt="Logo" width="65px"
                height="45px" style="border-radius: 35px" />
        </a> --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
            aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="{{ route('home-page') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home-page') }}">À propos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home-page') }}">Produits</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact.us') }}">Contact</a></li>
            </ul>
        </div>

        <!-- Language selector (visible en permanence) -->
        {{-- <div class="d-flex align-items-center ms-3">
            <select id="langchange" class="form-select form-select-sm langchange lang-select"
                aria-label="Sélection de la langue">
                <option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>Fr</option>
                <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>En</option>
            </select>
        </div> --}}
    </div>
</nav>
