<header class="bg-primary">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <!-- <a class="navbar-brand" href="#"></a> -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse  " id="navbarNav">
        <ul class="navbar-nav ">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('product')? 'active' : '' }}" href="{{route('products') }}">Sản phẩm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('customer')? 'active' : '' }}" href="{{route('customers') }}">Khách hàng</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('user')? 'active' : '' }}" href="{{route('users') }}">Users</a>
            </li>
        </ul>
      </div>
      <ul class="navbar-nav ">
        <li class="nav-item dropdown justify-content-end">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            @if (Auth::check())
              <span class="fa fa-user-circle-o"></span> Admin
            @else
              <span class="fa fa-user-circle-o"></span> Guest
            @endif
          </a>
          <ul class="dropdown-menu">
            @if (Auth::check())
              <li><a class="dropdown-item" href="#">{{ Auth::user()->name }}</a></li>
              <li><a class="dropdown-item" href="{{route('logout') }}">Đăng xuất</a> @csrf</li>
            @else
              <li><a class="dropdown-item" href="{{route('getLogin') }}">Đăng nhập</a> @csrf</li>
            @endif
          </ul>
        </li>
      </ul>
    </div>
  </nav>  
</header>