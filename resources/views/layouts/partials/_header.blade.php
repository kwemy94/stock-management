<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="navbar-wrapper">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="index.html">
                            <img src="{{ asset('front-template/assets/images/logo/logo.png') }}" alt="Logo"
                                width="65px" height="65px" style="border-radius: 50px" />
                        </a>
                        <button class="navbar-toggler">
                            <span class="toggler-icon"> </span>
                            <span class="toggler-icon"> </span>
                            <span class="toggler-icon"> </span>
                        </button>

                        <div class="navbar-collapse">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="menu-scroll" href="#home">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="menu-scroll" href="#features">Features</a>
                                </li>
                                <li class="nav-item">
                                    <a class="menu-scroll" href="#about">About</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="menu-scroll" href="#faq">FAQ</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="menu-scroll" href="#team">Team</a>
                                </li>
                                <li class="nav-item">
                                    <a class="" href="#contact">{{ __('auth.login') }}</a>
                                </li>
                                <li class="nav-item"> 
                                    {{-- <div class="col-md-4"> --}}
                                    {{-- <img src="https://flagcdn.com/16x12/us.png"
                                        srcset="https://flagcdn.com/32x24/us.png 2x, https://flagcdn.com/48x36/us.png 3x"
                                        width="16" height="12" alt="us"> --}}
                                    <select class="Langchange">
                                        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>En</option>
                                        <option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>Fr</option>
                                    </select>
                                    {{-- </div> --}}
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
