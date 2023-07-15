  <!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('public/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('public/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link @if (Request::segment(1)=='home' ) active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p> Dashboard </p>
            </a>
          </li>
          <li class="nav-item @if (Request::segment(1)=='component-categories' || Request::segment(1)=='components' ||
              Request::segment(1)=='component-visibilites' || \Request::route()->getName() == 'component-brand.index') menu-is-opening
            menu-open @endif">
            <a href="#" class="nav-link @if (Request::segment(1)=='component-categories' || Request::segment(1)=='components' ||
               Request::segment(1)=='component-visibilites' || \Request::route()->getName() == 'component-brand.index') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Components
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('components.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'components.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Components</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('components.create') }}" class="nav-link @if (\Request::route()->getName() ==
                  'components.create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Component</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('component-categories.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'component-categories.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Component Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('component-categories.create') }}" class="nav-link @if (\Request::route()->getName() ==
                  'component-categories.create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Component Category</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('component-visibilites.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'component-visibilites.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Component Visibility</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('component-brand.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'component-brand.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Component Brand</p>
                </a>
              </li>


            </ul>
          </li>
          <li class="nav-item @if (Request::segment(1)=='custom-build-categories' ||
              Request::segment(1)=='custom-build-categories' || Request::segment(1)=='custom-build' ) menu-is-opening  menu-open @endif">
            <a href="#" class="nav-link @if (Request::segment(1)=='custom-build-categories' ||
               Request::segment(1)=='custom-build-categories' || Request::segment(1)=='custom-build' ) active @endif">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Custom Build
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('custom-build.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'custom-build.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Custom Build</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('custom-build.create') }}" class="nav-link @if (\Request::route()->getName() ==
                  'custom-build.create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Custom Build</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('custom-build-categories.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'custom-build-categories.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Custom Build Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('custom-build-categories.create') }}" class="nav-link @if (\Request::route()->getName() ==
                  'custom-build-categories.create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Custom Build Categories</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item @if (Request::segment(1)=='promotion' ) active @endif">
            <a href="#" class="nav-link @if (Request::segment(1)=='promotion' ) active @endif">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Promotions
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('promotion.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'promotion.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Promotions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('promotion.create') }}" class="nav-link @if (\Request::route()->getName() ==
                  'promotion.create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add promotions</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item @if (Request::segment(1)=='accessories-categories' || Request::segment(1)=='accessories' ||
              Request::segment(1)=='component-visibilites' || \Request::route()->getName() == 'component-brand.index') menu-is-opening
            menu-open @endif">
            <a href="#" class="nav-link @if (Request::segment(1)=='accessories-categories' || Request::segment(1)=='accessories' ||
               Request::segment(1)=='component-visibilites' || \Request::route()->getName() == 'component-brand.index') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Accessories
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('accessories.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'accessories.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Accessories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('accessories.create') }}" class="nav-link @if (\Request::route()->getName() ==
                  'accessories.create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Accessory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('accessories-categories.index') }}" class="nav-link @if (\Request::route()->getName() ==
                  'accessories-categories.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Accessory Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('accessories-categories.create') }}" class="nav-link @if (\Request::route()->getName() ==
                  'accessories-categories.create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Accessory Category</p>
                </a>
              </li>


            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
