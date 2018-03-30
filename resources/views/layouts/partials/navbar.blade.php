<header class="app-header navbar">
  <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
    <span class="navbar-toggler-icon"></span>
  </button>

  <ul class="nav navbar-nav d-md-down-none">
    <li class="nav-item px-3">
      <a class="nav-link" href="/">Dashboard</a>
    </li> 
  </ul>
  <ul class="nav navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        @if (Auth::check())
          <span>{{ Auth::user()->email }}</span>
        @else
          <img src="{{ asset('images/avatars/avatar.jpg') }}" class="img-avatar" alt="avatar">
        @endif
      </a>
      <div class="dropdown-menu dropdown-menu-right">

        <a class="dropdown-item" href=""
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="fa fa-lock"></i> Logout </a>
      </div>
    </li>
  </ul>
  


 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  {{ csrf_field() }}
</form>
</header>
