 {{-- Brand Logo  --}}
<a href="{{route('dashboard')}}" class="brand-link">
  <img src="{{ asset('front-template/assets/images/logo/logo.png')}}" alt="TechB"
      class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text ">Tech Briva - S.M.</span>
</a>

<div class="sidebar">

     {{-- Sidebar Menu  --}}
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Stock Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('product.index')}}" class="nav-link {{request()->routeIs('product.index')? 'active': ''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{request()->routeIs('product.create')? 'active': ''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Category</p>
                        </a>
                    </li>
                </ul>
            </li>
           
            <li class="nav-header">POS</li>
            <li class="nav-item">
                <a href="pages/calendar.html" class="nav-link">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <p>
                        Sale
                        <span class="badge badge-info right">2</span>
                    </p>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="pages/gallery.html" class="nav-link">
                    <i class="nav-icon far fa-image"></i>
                    <p>
                        Gallery
                    </p>
                </a>
            </li> --}}
        </ul>
    </nav>
    
</div>
