@if ($message = Session::get('success'))
    <div class="vesu_alert_success_any animate__animated text-center vesu_alert_any">
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="vesu_alert_danger_any animate__animated text-center vesu_alert_any">
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('warning'))

    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close close-alert " data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif
<div class="vesu_alert_success animate__animated text-center">
</div>

<div class="vesu_alert_danger animate__animated text-center">
</div>



