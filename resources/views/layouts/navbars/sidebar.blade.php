<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="" class="simple-text logo-normal">
      {{ __('Virtual Kitchen') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('chief') || auth()->user()->hasRole('accountant'))
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasRole('admin'))
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#usermanager" aria-expanded="false">
          <i><img style="width:25px" src="{{ asset('material') }}/img/usersmanager.jpg"></i>
          <p>{{ __('Users Manager') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="usermanager">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @endif
      @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('chief') || auth()->user()->hasRole('driver'))
    
      <li class="nav-item{{ $activePage == 'orders' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('orders.index') }}">
          <i class="material-icons">Orders</i>
            <p>{{ __('Orders') }}</p>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('chief') )
    
      <li class="nav-item{{ $activePage == 'menu' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('items.index') }}">
            <i class="material-icons">Menu</i> 
            <p>{{ __('Menu') }}</p>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasRole('admin') )
    
      <li class="nav-item{{ $activePage == 'Drivers' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('drivers.index') }}">
          <i class="material-icons">Drivers</i>
            <p>{{ __('Drivers') }}</p>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('chief') )
    
      <li class="nav-item{{ $activePage == 'Assets' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('assets.index') }}">
          <i class="material-icons">Assets</i>
            <p>{{ __('Assets') }}</p>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('chief') )
    
      <li class="nav-item{{ $activePage == 'Stocks' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('stocks.index') }}">
          <i class="material-icons">Stocks</i>
            <p>{{ __('Stocks') }}</p>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasRole('admin') )
    
      <li class="nav-item{{ $activePage == 'clients' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('clients.index') }}">
          <i class="material-icons">Clients</i>
            <p>{{ __('Clients') }}</p>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasRole('admin'))
      <li class="nav-item{{ $activePage == 'finances' ? ' active' : '' }}">
       
        <a class="nav-link" href="{{ route('finances.admin') }}">
         
          <i class="material-icons">Finances</i>
          <p>{{ __('Finances') }}</p>
        </a>
      </li>
      @endif

      @if(auth()->user()->hasRole('accountant'))
      <li class="nav-item{{ $activePage == 'finances' ? ' active' : '' }}">
       
        <a class="nav-link" href="{{ route('finances.accountant') }}">
         
          <i class="material-icons">Finances</i>
          <p>{{ __('Finances') }}</p>
        </a>
      </li>
      @endif
     
      @if(auth()->user()->hasRole('admin'))
      <li class="nav-item{{ $activePage == 'expences' ? ' active' : '' }}">
       
        <a class="nav-link" href="{{ route('expences.index') }}">
         
          <i class="material-icons">Expences</i>
          <p>{{ __('Expences') }}</p>
        </a>
      </li>
      @endif

      @if(auth()->user()->hasRole('accountant'))
      <li class="nav-item{{ $activePage == 'expences' ? ' active' : '' }}">
       
        <a class="nav-link" href="{{ route('expences.index') }}">
         
          <i class="material-icons">Expences</i>
          <p>{{ __('expences') }}</p>
        </a>
      </li>
      @endif
     
     
    </ul>
  </div>
</div>
