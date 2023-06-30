<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler md_btn" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{route('dashboard')}}">
            <img src="/assets/img/brand/myvesu_logo.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                      <span class="avatar avatar-sm rounded-circle">
                        <img alt="{{auth()->user()->username}}" src="/uploads/avatar/{{auth()->user()->avatar}}">
                      </span>
                    </div>
                </a>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{route('dashboard')}}">
                            <img src="/assets/img/brand/myvesu_logo.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <ul class="navbar-nav side_nav">
                <li class="nav-item  active ">
                    <a class="nav-link  active " href="/">
                        <i class="ni ni-tv-2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#admin" data-toggle="collapse" data-target="#admin" aria-expanded="false" aria-controls="admin">
                        <i class="ni ni-single-02 text-yellow"></i>
                        Users & Permission
                    </a>
                    <div id="admin" class="collapse">
                        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                            <li class="nav-link sub_link"><a href="{{route('administrators')}}" class="sidebar-link text-muted pad-left">Administrators</a></li>
                            <li class="nav-link sub_link"><a href="{{route('users')}}" class="sidebar-link text-muted pad-left">Users</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('drivers.list')}}" data-toggle="collapse" data-target="#driver" aria-expanded="false" aria-controls="driver">
                        <i class="fa fa-car text-red"></i>
                        Drivers
                    </a>
                    <div id="driver" class="collapse">
                        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                            <li class="nav-link sub_link"><a href="{{route('driver.add')}}" class="sidebar-link text-muted pad-left">Add Driver</a></li>
                            <li class="nav-link sub_link"><a href="{{route('drivers.list')}}" class="sidebar-link text-muted pad-left">Drivers List</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('passengers')}}">
                        <i class="fa fa-users text-green"></i>
                        Passengers
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('dashboard.rides')}}">
                        <i class="fa fa-road text-info"></i>
                        Rides
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('map')}}">
                        <i class="fa fa-map-marked-alt text-warning"></i>
                        Map
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#destination" data-toggle="collapse" data-target="#destination" aria-expanded="false" aria-controls="destination">
                        <i class="fa fa-map-marker-alt text-yellow"></i>
                        Destinations
                    </a>
                    <div id="destination" class="collapse">
                        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                            <li class="nav-link sub_link"><a href="{{route('dashboard.destinations')}}" class="sidebar-link text-muted pad-left">Destinations list</a></li>
                            <li class="nav-link sub_link"><a href="{{route('destination.make')}}" class="sidebar-link text-muted pad-left">Add destination</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
