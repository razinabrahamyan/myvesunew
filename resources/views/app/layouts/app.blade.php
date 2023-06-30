<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link href="{{ asset('/assets/img/brand/myvesu_logo.png') }}" rel="icon" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <script src="{{asset('/assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
    <link href="{{ asset('/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />
</head>
<body
    class='{{auth()->user()->settings()->first() && auth()->user()->settings()->first()->night_mode && auth()->user()->settings()->first()->night_mode == 1 ? "night_mode" : ""}}' >
<div style="height: 88px !important;"></div>
<div id="app">
    @include('app.layouts.sidenav')
    @include('app.layouts.navbar')
    <main class="main">
        @include('app.layouts.flash-message')
        @yield('content')
    </main>

    <div class="footer">
        <div class="row">
            <div class="col-4">
                <button class="back_btn pl-2" onclick="goBack()">
                    <i class="fa fa-angle-left"></i>
                </button>
            </div>
            <div class="col-4 text-center pt-2">
                <a href="{{route("app.booking")}}" class="plus_btn ">
                    <div>
                        <i class="fa fa-plus-circle add_rides_img"></i>
                    </div>
                </a>
            </div>
            <div class="col-4 text-right pt-2">
                <a href="{{route("app.settings")}}" class="plus_btn ">
                    <div>
                        <i class="fa fa-cog pr-2"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>
<script src="{{asset('/assets/js/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/main.js')}}"></script>
<script src="{{asset('/js/popper.min.js')}}"></script>
<script src="{{asset('/js/moment.min.js')}}"></script>
<script src="{{asset('/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="{{asset('/assets/js/app/pullToRefresh.js')}}"></script>
<script type="text/javascript">
    function goBack() {
        window.history.back();
    }
    let is_on_screen = true;

    if (!document.getElementById('is_on_chat_page')) {
        PullToRefresh.init({
            mainElement: '#app',
            onRefresh: function () {
                window.location.reload();
            },
            distThreshold: 70,
            distReload: 70,
            disMax: 50,
            classPrefix: 'vesu_reloading_',
            refreshTimeout: 150,
            triggerElement: 'body',
            iconRefreshing: ' ',
        });
    }
    $(document).ready(function () {
        let alert = $(".vesu_alert_any");
        alert.css("display", "block");
        alert.addClass("animate__fadeInDownBig");
        let alert_timeout = setTimeout(function () {
            alert.hide(400);
        }, 2000)
    })
</script>
</body>
</html>
