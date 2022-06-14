<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <router-link to="/dashboard" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt blue"></i>
        <p>
          Dashboard
        </p>
      </router-link>
    </li>

    @if(Auth::user()->isAdmin())
    <li class="nav-item">
      <router-link to="/users" class="nav-link">
        <i class="fa fa-users nav-icon blue"></i>
        <p>Users</p>
      </router-link>
    </li>
    @endif

    @if(Auth::user()->isAdmin())
    <li class="nav-item">
      <router-link to="/products" class="nav-link">
        <i class="nav-icon fas fa-list-ol green"></i>
        <p>
          Products
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/services" class="nav-link">
        <i class="nav-icon fas fa-tags green"></i>
        <p>
          Services
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/product/category" class="nav-link">
        <i class="nav-icon fas fa-list-ol green"></i>
        <p>
          Categories
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/product/tag" class="nav-link">
        <i class="nav-icon fas fa-tags green"></i>
        <p>
          Tags
        </p>
      </router-link>
    </li>
    @else
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cog green"></i>
        <p>
          Services
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <router-link to="/user/services" class="nav-link">
            <i class="nav-icon fas fa-user green"></i>
            
            <p>
              My Services
            </p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/services" class="nav-link">
            <i class="nav-icon fas fa-users orange"></i>
            <p>
              Services
              <span class="badge badge-info right">6</span>
            </p>
          </router-link>
        </li>
      </ul>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-bullhorn gray"></i>
        <p>
          Requests
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <router-link to="/requests/sent" class="nav-link">
            <i class="nav-icon fas fa-paper-plane orange"></i>
            <p>
              Sent
            </p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/requests/recieved" class="nav-link">
            <i class="nav-icon fas fa-inbox green"></i>
            <p>
              Recieved
            </p>
          </router-link>
        </li>
      </ul>
    </li>
    


    @endif





    @if(Auth::user()->isAdmin())
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cog green"></i>
        <p>
          Settings
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">



        <li class="nav-item">
          <router-link to="/developer" class="nav-link">
            <i class="nav-icon fas fa-cogs white"></i>
            <p>
              Developer
            </p>
          </router-link>
        </li>
      </ul>
    </li>

    @endif



    <li class="nav-item">
      <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
        <i class="nav-icon fas fa-power-off red"></i>
        <p>
          {{ __('Logout') }}
        </p>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
  </ul>
</nav>