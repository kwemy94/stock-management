<ul class="navbar-nav ml-auto">

    {{-- Language Selector --}}
    <li class="nav-item d-flex align-items-center mr-3">
        <select class="Langchange form-control form-control-sm" style="width: 70px; border-radius: 6px; cursor: pointer;">
            <option value="fr" {{ session('locale') == 'fr' ? 'selected' : '' }}>Fr</option>
            <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>En</option>
        </select>
    </li>

    {{-- User Dropdown --}}
    <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" aria-expanded="false">
            <img src="{{ asset('dashboard-template/dist/img/avatar.png') }}" alt="User Avatar"
                class="img-circle elevation-2" style="width: 32px; height: 32px; object-fit: cover;">
        </a>

        <div class="dropdown-menu dropdown-menu-right shadow-sm" style="min-width: 220px;">

            {{-- User Name --}}
            <div class="dropdown-header text-center font-weight-bold">
                {{ Auth::user()->name }}
            </div>

            <div class="dropdown-divider"></div>

            {{-- Profile --}}
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                <i class="fas fa-user mr-2 text-primary"></i> {{ __('Profile') }}
            </a>

            <div class="dropdown-divider"></div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item text-danger"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                </button>
            </form>

        </div>
    </li>

    {{-- Settings Button --}}
    <li class="nav-item ml-2">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"
            title="Configuration de base">
            <i class="fas fa-cog fa-spin" style="font-size: 18px;"></i>
        </a>
    </li>

</ul>
