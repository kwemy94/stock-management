 <style>
    .nav-header{
        color: blue;
        font-weight: bold;
    }
 </style>
 
 {{-- Brand Logo  --}}
 <a href="{{ route('dashboard') }}" class="brand-link">
     <img 
     src='{{ isset($setting->logo) ? asset("storage/images/logo/$setting->logo") : asset("front-template/assets/images/logo/logo.png") }}'
     alt="TechB"
         class="brand-image img-circle elevation-3" style="opacity: .8">
     <span class="brand-text ">Tech Briva</span>
 </a>

 <div class="sidebar">

     {{-- Sidebar Menu  --}}
     <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
             <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
             <li class="nav-item">
                 <a href="{{ route('category.index') }}" class="nav-link {{request()->routeIs('category.index')? 'active': ''}}">
                     <i class="nav-icon far fa-calendar-alt"></i>
                     <p>
                        {{ __('dashboard.category') }}
                     </p>
                 </a>
             </li>
             
             <li class="nav-item">
                 <a href="{{ route('product.index') }}" class="nav-link {{request()->routeIs('product.index')? 'active': ''}}">
                     <i class="nav-icon far fa-calendar-alt"></i>
                     <p>
                        {{ __('dashboard.product') }}
                     </p>
                 </a>
             </li>
             <li class="nav-item">
                 <a href="{{ route('customer.index')}}" class="nav-link {{request()->routeIs('customer.index')? 'active': ''}}">
                     <i class="nav-icon fas fa-users"></i>
                     <p>
                        {{__('dashboard.customer')}}
                     </p>
                 </a>
             </li>
             <li class="nav-header">Approvisionnement</li>
             <li class="nav-item">
                <a href="{{ route('supplier.index') }}" class="nav-link {{request()->routeIs('supplier.index')? 'active': ''}}">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                       {{ __('dashboard.supplier') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('achat.index') }}" class="nav-link {{request()->routeIs('achat.index')? 'active': ''}}">
                    <i class="nav-icon fas fa-cart-arrow-down"></i>
                    <p>
                       {{ __('Achat') }}
                    </p>
                </a>
            </li>

             <li class="nav-header">POS</li>
             <li class="nav-item">
                 <a href="{{ route('order.index')}}" class="nav-link">
                     <i class="nav-icon fas fa-cart-plus"></i>
                     <p>
                         {{ __('dashboard.order') }}
                         <span class="badge badge-info right">2</span>
                     </p>
                 </a>
             </li>
             <li class="nav-item">
                 <a href="{{route('sale.index')}}" class="nav-link">
                     <i class="nav-icon far fa-calendar-alt"></i>
                     <p>
                         {{ __('dashboard.sale') }}
                     </p>
                 </a>
             </li>
             <li class="nav-header">Administration</li>
             <li class="nav-item">
                 <a href="{{route('unite-mesure.index')}}" class="nav-link">
                     <i class="nav-icon fas fa-balance-scale"></i>
                     <p>
                         {{ __('Unité de mesure') }}
                     </p>
                 </a>
             </li>
             <li class="nav-item">
                 <a href="#" class="nav-link">
                     <i class="nav-icon fas fa-user-cog"></i>
                     <p>
                         {{ __('dashboard.user') }}
                     </p>
                 </a>
             </li>
             <li class="nav-item">
                 <a href="{{ route('setting.index') }}" class="nav-link {{request()->routeIs('setting.index')? 'active': ''}}">
                     <i class="fa-solid fa fa-cog fa-spin fa-1x fa-fw"></i>
                     <p>
                        {{ __('dashboard.setting') }}
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
