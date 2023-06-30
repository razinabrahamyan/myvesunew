<!-- Navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{route('dashboard')}}">Dashboard</a>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="{{auth()->user()->username}}" src="/uploads/avatar/{{auth()->user()->avatar}}">
                </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{auth()->user()->username}}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <a href="{{route("profile")}}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>My profile</span>
                    </a>
                    <a href="{{route("change.pass")}}" class="dropdown-item">
                        <i class="ni ni-key-25"></i>
                        <span>Change pass</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <form  action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item" style="cursor: pointer">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- End Navbar -->

<!-- Header Body -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 256px; background-image: url(/assets/img/brand/banner.png); background-size: cover; background-position: center top;">
        <span class="mask bg-gradient-primary opacity-8"></span>
        <div class="container-fluid">
            <div class="header-body">

            </div>
        </div>
    </div>
<!-- End Header -->
