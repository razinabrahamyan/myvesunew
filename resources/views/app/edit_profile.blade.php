@extends('app.layouts.app')

@section('title')
    <h5>PROFILE EDIT</h5>
@endsection

@section('content')

        <form action="{{route('app.profile.update')}}" enctype="multipart/form-data" method="post" class="profile_edit_form">
            @csrf
            <div class="form-group form" id="users_image_div">
                <img src="{{asset('uploads/avatar/'.Auth::user()->avatar)}}" alt="" id="profile_img" >
                <div class="container-fluid users_absolute_place upload_photo_profile" id="image_upload_div">
                    Upload Photo <span><i class="fa fa-cloud-upload-alt"></i></span>
                </div>
                <input type="file" style="display: none" id="image_upload_input" name="image" accept="image/png, image/jpeg">
            </div>
            <div class="container">
                <div class="animate__animated animate__bounceInLeft container-fluid pb-1 pt-2">
                    <div class="form-group">
                        <label for="first_name" class="">Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control{{$errors->has('first_name') ? ' is-invalid':''}}" value="{{Auth::user()->first_name}}">
                        @if($errors->has('first_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="">Surname</label>
                        <input type="text" name="last_name" id="last_name" class="form-control{{$errors->has('last_name') ? ' is-invalid':''}}" value="{{Auth::user()->last_name}}">
                        @if($errors->has('last_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="country" class="">Country</label>
                        <select name="country" id="country" class="form-control{{$errors->has('country') ? ' is-invalid':''}}">
                            <option value="{{$country->name}}" selected="selected">{{$country->name}}</option>
                        </select>
                        @if($errors->has('country'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="state" class="">State</label>
                        <select name="state" id="input_state" class="form-control{{$errors->has('state') ? ' is-invalid':''}}">
                            @foreach($country->states as $state)
                                <option value="{{$state->name}}"
                                        @if(old('state'))
                                            @if(old('state') === $state->name)
                                                selected="selected"
                                            @endif
                                        @else
                                            @if(Auth::user()->state === $state->name)
                                                selected="selected"
                                            @endif
                                        @endif
                                >{{$state->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('state'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('state') }}</strong>
                            </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="city" class="">City</label>
                        <select name="city" id="input_city" class="form-control{{$errors->has('city') ? ' is-invalid':''}}">
                            <option value="0" selected="selected">Select a city</option>
                        </select>
                        @if($errors->has('city'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="phone" class="">Contact</label>
                        <input type="text" name="phone" id="phone" class="form-control{{$errors->has('phone') ? ' is-invalid':''}}" value="{{Auth::user()->phone}}">
                        @if($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="about" class="">About</label>
                        <textarea name="about" id="about" class="form-control{{$errors->has('about') ? ' is-invalid':''}}">{{Auth::user()->about}}</textarea>
                        @if($errors->has('about'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('about') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group profile_submit_div">
                        <div class="row container-fluid mx-auto justify-content-around">
                            <a href="{{route('app.profile')}}" class="btn col-5 edit_cancel_button">Cancel</a>
                            <button type="submit" class="btn col-5 edit_save_button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    <script>
        $(document).ready(function (){
            $('#image_upload_div').click(function () {
                $('#image_upload_input').trigger('click');
            });
            function previewFile() {
                let preview = document.getElementById('profile_img');
                let file    = document.querySelector('input[type=file]').files[0];
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                    preview.src = reader.result;
                }, false);
                if (file) {
                    reader.readAsDataURL(file);
                }
            }

            $('#image_upload_input').change(function () {
                previewFile();
            });
            if("{{old('state')}}") {
                $.ajax({
                    url: '{{route('app.profile.cities')}}',
                    type: "get",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {state: "{{old('state')}}"},
                    success: function (response) {
                        if (response && response.length > 0) {
                            $('#input_city').html('');
                            $.each(response, function (index, value) {
                                if("{{old('city')}}"){
                                    if("{{old('city')}}" === value.name){
                                        $('#input_city').append('<option selected="selected" value="' + value.name + '">' + value.name + '</option>');
                                    }
                                    else{
                                        $('#input_city').append('<option value="' + value.name + '">' + value.name + '</option>');
                                    }
                                }

                            });
                        }
                    }
                });
            }
            else {
                $.ajax({
                    url: '{{route('app.profile.cities')}}',
                    type: "get",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {state: "{{Auth::user()->state}}"},
                    success: function (response) {
                        if (response && response.length > 0) {
                            $('#input_city').html('');
                            $.each(response, function (index, value) {
                                if("{{Auth::user()->city}}"){
                                    if("{{Auth::user()->city}}" === value.name){
                                        $('#input_city').append('<option selected="selected" value="' + value.name + '">' + value.name + '</option>');
                                    }
                                    else{
                                        $('#input_city').append('<option value="' + value.name + '">' + value.name + '</option>');
                                    }
                                }
                            });
                        }
                    }
                });
            }

            $('#input_state').on('change', function () {
                $.ajax({
                    url: '{{route('app.profile.cities')}}',
                    type: "get",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {state: this.value},
                    success: function (response) {
                        if(response && response.length > 0) {
                            $('#input_city').html('');
                            $.each(response, function (index, value) {
                                $('#input_city').append('<option value="' + value.name + '">' + value.name + '</option>');
                            });
                        }
                    },
                })
            });

        })
    </script>
@endsection
