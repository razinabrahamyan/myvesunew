<!DOCTYPE html>
<html lang="en">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Myvesu Dashboard
    </title>
    <!-- Favicon -->
    <link href="{{ asset('/assets/img/brand/myvesu_logo.png') }}"  rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('/assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('/assets/css/argon-dashboard.css?v=1.1.1') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
    <script src="{{asset('/assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
</head>

<body class="nice_scroll">
@include('dashboard.includes.sidebar')

    <div class="main-content">
        @include('dashboard.includes.nav_bar')
        <div class="container-fluid mt--7">
            <div class="container-fluid mt--7">
                 @yield('content')
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">

                    </div>
                </div>
            </footer>
        </div>
    </div>

<!--   Core   -->
<script src="{{asset('/assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!--   Optional JS   -->
<script src="{{asset('/assets/js/plugins/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('/assets/js/plugins/chart.js/dist/Chart.extension.js')}}"></script>
<script src="{{asset('/assets/js/plugins/bootstrap-select/bootstrap-select.min.js')}}"></script>
<!--   Argon JS   -->
<script src="{{asset('/assets/js/argon-dashboard.js?v=1.1.1')}}"></script>
<script src="{{asset('https://cdn.trackjs.com/agent/v3/latest/t.js')}}"></script>
<script src="{{asset('/assets/js/script.js')}}"></script>
<script src="{{asset('/js/moment.min.js')}}"></script>
<script src="{{asset('/js/tempusdominus-bootstrap-4.min.js')}}"></script><script>
    window.TrackJS &&
    TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
    });

</script>
</body>

</html>
