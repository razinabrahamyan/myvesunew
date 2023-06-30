@extends('app.layouts.app')

@section('title')
    <h5>SETTINGS</h5>
@endsection
@section('content')
    <div class="alert alert-danger alert-block" style="display: none">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong class="danger_message"></strong>
    </div>
    <div class="col-12 pt-3 settings">
        @csrf
        <div class="container-fluid mt-3 pt-1 pb-2">
            <div class="row mt-2">
                <div class="col-8 setting">
                    <span class="setting_name">Night Mode</span>
                    <span class="setting_status">Disabled</span>
                </div>
                <div class="col-4 text-right setting_checkbox pt-2">
                    <label class="switch">
                        <input type="checkbox" id="night_mode" value="1" {{$setting && $setting->night_mode && $setting->night_mode == 1 ? "checked" : ""}}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-3 pb-1">
            <a href="{{route("app.notifications")}}">
                <div class="row mt-3 py-2">
                    <div class="col-8 setting">
                        <span class="setting_name">Notifications</span>
                    </div>
                    <div class="col-4 text-right pt-2">
                        <i class="fa fa-angle-right setting_icon_angle"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="container-fluid mt-3 pb-1">
            <a href="{{route("app.privacy")}}">
                <div class="row mt-3 py-2">
                    <div class="col-8 setting">
                        <span class="setting_name">Privacy</span>
                    </div>
                    <div class="col-4 text-right pt-2">
                        <i class="fa fa-angle-right setting_icon_angle"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="container-fluid mt-3 pb-1">
            <a href="{{route("app.about")}}">
                <div class="row mt-3 py-2">
                    <div class="col-8 setting">
                        <span class="setting_name">About this app</span>
                        <span class="setting_status">Version 1.1.0 </span>
                    </div>
                    <div class="col-4 text-right pt-2">
                        <i class="fa fa-angle-right setting_icon_angle"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
<script>
    $("#night_mode").change(function() {
        var night_mode = 0;
        if(this.checked) {
            night_mode = 1;
        }
        $.ajax({
            url: '{{route('app.user_settings')}}',
            type: "post",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {night_mode: night_mode},
            success: function (response) {
                if(response.status === "success"){
                    $('body').toggleClass('night_mode');

                }else{
                    $(".alert-danger").css("display", "block");
                    $(".danger_message").text(response.message);
                }
            }
        })

    });
</script>
@endsection

