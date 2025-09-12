<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <select class="Langchange">
            <option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>Fr</option>
            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>En</option>
        </select>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <img src="{{asset('dashboard-template/dist/img/user.jpeg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle"
                style="width: 32px">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item dropdown-footer">{{ Auth::user()->name }}</a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                {{ __('Profile') }}
            </a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" title="Configuration de base">
          <i class="fa-solid fa fa-cog fa-spin fa-1x fa-fw"></i>
        </a>
      </li>

</ul>
