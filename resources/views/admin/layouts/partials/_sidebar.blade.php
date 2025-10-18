 <style>
     .nav-header {
         color: #1f2d3d;
         font-weight: bold;
     }
     .brand-link:hover .brand-text {
         color: #1385ff !important;
     }
 </style>


 {{-- Brand Logo  --}}
 <a href="{{ route('dashboard') }}" class="brand-link">
     <img src='{{ asset('front-template/assets/images/logo/logo.png') }}'
         alt="TechB" class="brand-image img-circle elevation-3" style="opacity: .8">
     <span class="brand-text ">Street Smart</span>
 </a>

 <div class="sidebar">

     {{-- Sidebar Menu  --}}
     <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
             <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

             
             <li class="nav-header">Approvisionnement</li>
             <li class="nav-item">
                 <a href="{{ route('buy.home') }}" class="nav-link">
                     <i class="nav-icon fa fa-home"></i>
                     <p>
                         {{ __('Home achat') }}
                     </p>
                 </a>
             </li>
             <li class="nav-item">
                 <a href="{{ route('achat.index') }}"
                     class="nav-link {{ request()->routeIs('achat.index') ? 'active' : '' }}">
                     <i class="nav-icon fas fa-shopping-cart"></i>
                     <p>
                         {{ __('Achat') }}
                     </p>
                 </a>
             </li>

             <li class="nav-header">POS</li>
             <li class="nav-item">
                 <a href="{{ route('order.index') }}" class="nav-link">
                     <i class="nav-icon fas fa-box"></i>
                     <p>
                         {{ __('dashboard.order') }}
                         {{-- <span class="badge badge-info right">2</span> --}}
                     </p>
                 </a>
             </li>
             <li class="nav-item">
                 <a href="{{ route('sale.invoice') }}" class="nav-link">
                     <i class="nav-icon fas fa-cash-register"></i>
                     <p>
                         {{ __('dashboard.sale') }}
                     </p>
                 </a>
             </li>
             {{-- <li class="nav-header">Administration</li> --}}

             {{-- <li class="nav-item has-treeview menu-open">
                 <a href="#" class="nav-link active">
                     <i class="nav-icon fas fa-book"></i>
                     <p>
                         {{ __('dashboard.treasury.treasury-title') }}
                         <i class="fas fa-angle-left right"></i>
                     </p>
                 </a>
                 <ul class="nav nav-treeview" style="display: none;">
                     <li class="nav-item">
                         <a href="{{ route('expense.index') }}" class="nav-link">
                             <i class="far fa-circle nav-icon"></i>
                             <p>{{ __('dashboard.treasury.expense') }}</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('recipe.index') }}" class="nav-link">
                             <i class="far fa-circle nav-icon"></i>
                             <p>{{ __('dashboard.treasury.recipe') }}</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('analyse.treso') }}" class="nav-link">
                             <i class="far fa-circle nav-icon"></i>
                             <p>{{ __('dashboard.treasury.analyse') }}</p>
                         </a>
                     </li>
                    
                 </ul>
             </li> --}}
         </ul>
     </nav>

 </div>
