<div id="leftSidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" id="navCloseButton"><i class="fa fa-backspace"></i></a>
    <div class="sidenav-info-div container-fluid">
        <div class="sidenav-image-div mx-auto">
            <img src="/uploads/avatar/{{Auth::user()->avatar}}" alt="">
        </div>
        <div class="sidenav-user-div container-fluid text-center">
            <p>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</p>
            <p>{{Auth::user()->address}}</p>
            <p>{{Auth::user()->country}}, {{Auth::user()->state}}, {{Auth::user()->city}}</p>
        </div>
    </div>
    <div class="sidenav-links-div">
        <a href="{{route('app.profile')}}">Profile</a>
        <a href="{{route('app.wallet')}}">Wallet</a>
        <a href="{{route('app.booking')}}">Book Now</a>
        <a href="{{route('app.chats')}}">Messages</a>
        <a href="{{route('app.own.rides')}}">Rides</a>
        <a href="{{route('app.notifications')}}">Notifications</a>
        <a href="{{route('app.contact')}}">Contact Us</a>
        <a href="{{route('app.logout', ["fcm_token" => auth()->user()->fcm_token, "lat" => auth()->user()->lat, "lng" => auth()->user()->lng,"brand"=>auth()->user()->brand])}}">Logout</a>
    </div>

</div>
