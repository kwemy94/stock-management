{{-- <section class="hero" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-6 col-xl-6">
                <div class="hero-content wow fadeInUp" data-wow-delay=".2s">
                    <h1 class="hero-title">Expertise et développement informatique sur mesure</h1>
                    <p class="hero-desc">
                        D’un simple Site web à un Logiciel complet, notre équipe spécialisée en Ingénierie Logicielle analyse précisément vos besoins et développe la solution la plus adaptée en s’appuyant sur des technologies reconnues.
                    </p>
                    <a href="#contact" class="main-btn">Avez-vous un projet? Contactez nous!</a>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6">
                <div class="hero-image wow fadeInUp" data-wow-delay=".25s">
                    
                    <img src="{{asset('front-template/assets/images/hero/dev3.png')}}" alt="image"
                        class="image" />
                </div>
            </div>
        </div>
    </div>
</section> --}}

<header class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1>Expertise et développement d'application sur mesure</h1>
                <p>D’un simple site web à un logiciel complet, notre équipe analyse vos besoins et développe la solution
                    la plus adaptée en s’appuyant sur des technologies modernes.</p>
                <a href="{{ route('contact.us') }}" class="btn btn-lg mt-3">Avez-vous un projet ? Contactez-nous !</a>
            </div>
            <!-- Colonne droite : Carousel -->
            <div class="col-lg-6 text-center d-none d-lg-block">
                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow">
                        <div class="carousel-item active">
                            <img src="{{asset('front-template/assets/images/hero/dev3.png')}}" class="d-block w-100" alt="Mockup 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{asset('front-template/assets/images/hero/dev.webp')}}" class="d-block w-100" alt="Mockup 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{asset('front-template/assets/images/hero/dev2.png')}}" class="d-block w-100" alt="Mockup 3">
                        </div>
                        <div class="carousel-item">
                            <img src="{{asset('front-template/assets/images/hero/dev4.png')}}" class="d-block w-100" alt="Mockup 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
