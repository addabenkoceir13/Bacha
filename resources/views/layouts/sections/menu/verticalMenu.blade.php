<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
      <a href="#" class="app-brand-link">
          <span class="app-brand-logo demo">
              <img width="25" src="{{ asset('assets/img/favicon/favicon.ico') }}" alt="brand-logo" srcset="">
              {{-- @include('_partials.macros',["width"=>25,"withbg"=>'#696cff']) --}}
          </span>
          <span class="app-brand-text demo menu-text fw-bold text-capitalize ms-2">
              {{ config('app.locale') == 'en' ? "MohAdda" : "محمد عدة"  }}
          </span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
      <li class="menu-header small text-uppercase">
          <span class="menu-header-text">{{ __('dashboard') }}</span>
      </li>
      <li class="menu-item {{ request()->routeIs('dashboard-analytics') ? 'active' : '' }}">
          <a href="{{ route('dashboard-analytics') }}" class="menu-link">
              {{-- <i class="menu-icon tf-icons bx bx-collection"></i> --}}
              <i class='menu-icon bx bxs-dashboard'></i>
              <div>{{ __('dashboard') }}</div>
          </a>
      </li>

      <li class="menu-header small text-uppercase">
          <span class="menu-header-text">{{ __('Services for construction') }}</span>
      </li>

      <li class="menu-item {{ request()->routeIs('services.*') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" >
            <i class='menu-icon bx bx-cog'></i>
            <div>{{ __('Services') }}</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->routeIs('services') ? 'active' : '' }}">
            <a href="" class="menu-link">
                <div>{{ __('Building Materials') }}</div>
            </a>
          </li>

          <li class="menu-item {{ request()->routeIs('services') ? 'active' : '' }}">
            <a href="" class="menu-link">
                <div>{{ __('Tractor driver') }}</div>
            </a>
          </li>



        </ul>
      </li>

</aside>

