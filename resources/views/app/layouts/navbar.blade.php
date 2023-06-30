<nav class="navbar navbar-expand-md navbar_myvesu pt-4 fixed-top">
    <div class="container">
        <span class="left_nav_icon" onclick="openNav()">
            <div style="width: 30px"></div>
            <div style="width: 21px"></div>
            <div style="width: 12px"></div>
        </span>
        @yield('title')
        <a class="right_nav_icon" href="{{route('app.notifications')}}"><i class="fa fa-bell" aria-hidden="true"></i><span class="notification_count">{{Auth::user()->notifications->where('active','1')->count()}}</span></a>
    </div>
</nav>
