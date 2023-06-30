@extends('app.auth.layouts.app')

@section('content')
    <div class="container auth_page">
        <div class="col-12 auth_page_title text-center">
            <h1>REGISTRIEREN</h1>
        </div>
        <div class="col-12 text-center">
            <a href="{{route('app.login', ["fcm_token" => $fcm_token, "lat" => $lat, "lng" => $lng])}}" class="login_link">
                <span class="center register_title_desc">Have An Account ? Login</span>
            </a>
        </div>
        <div class="col-12">
            <form method="POST" action="{{route('app.register', ["fcm_token" => $fcm_token, "lat" => $lat, "lng" => $lng])}}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}" required>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required>

                        @if ($errors->has('first_name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required>

                        @if ($errors->has('last_name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="E-Mail Address" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Phone Number" name="phone" value="{{ old('phone') }}" required>

                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Address" name="address" value="{{ old('address') }}" required>

                        @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <select  name="country" id="input-country" class="form-control form-control-alternative {{ $errors->has('country') ? ' is-invalid' : '' }}">
                            <option value="{{$country->name}}" @if (old('country') == $country->name) selected="selected" @endif>{{$country->name}}</option>
                        </select>

                        @if ($errors->has('country'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <select  name="state" id="input-state" class="form-control form-control-alternative {{ $errors->has('state') ? ' is-invalid' : '' }}">
                            <option value="0">Select State</option>
                            @foreach($country->states as $state)
                                <option value="{{$state->name}}" @if (old('state') == $state->name) selected="selected" @endif>{{$state->name}}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('state'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('state') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <select  name="city" id="input-city" class="form-control form-control-alternative {{ $errors->has('city') ? ' is-invalid' : '' }}">
                            <option value="0" >Select City</option>
                        </select>

                        @if ($errors->has('city'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="zip" type="text" class="form-control{{ $errors->has('zip') ? ' is-invalid' : '' }}" placeholder="Zip Code" name="zip" value="{{ old('zip') }}" required>

                        @if ($errors->has('zip'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('zip') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Password Confirmation" name="password_confirmation" required>

                    </div>
                </div>

                <div class="additional_address additional_address_hide">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="company_name" type="text" class="form-control" placeholder="Company Name" name="company_name" value="{{ old('company_name') }}">

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="company_address" type="text" class="form-control" placeholder="Company Address" name="company_address" value="{{ old('company_address') }}">

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="cost_unit" type="text" class="form-control" placeholder="Cost Unit" name="cost_unit" value="{{ old('cost_unit') }}">

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="free_text" type="text" class="form-control" placeholder="Free Text" name="free_text" value="{{ old('free_text') }}">

                        </div>
                    </div>
                </div>

                <div class="col-md-12 text-center additional_address_text">
                    <span>+ additional invoice address</span>
                </div>

                <div class="form-group row mt-5">
                    <div class="col-md-8 offset-md-4 text-center">
                        <button type="submit" class="btn btn-default btn_auth">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script>

        $(document).ready(function(){
            $(".additional_address_text").on( "click", function() {
               if($('.additional_address').hasClass('additional_address_hide')){
                   $(".additional_address").removeClass("additional_address_hide");
                   $(".additional_address").addClass("additional_address_show");
                   $(".additional_address_text").html("<span>- additional invoice address</span>")
               }else if($('.additional_address').hasClass('additional_address_show')){
                   $(".additional_address").removeClass("additional_address_show");
                   $(".additional_address").addClass("additional_address_hide");
                   $(".additional_address_text").html("<span>+ additional invoice address</span>")
               }
            });


            if("{{old('state')}}") {
                $.ajax({
                    url: '{{route('app.cities')}}',
                    type: "get",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {state: "{{old('state')}}"},
                    success: function (response) {
                        if (response && response.length > 0) {
                            $('#input-city').html('');
                            $.each(response, function (index, value) {
                                $('#input-city').append('<option value="' + value.name + '">' + value.name + '</option>');
                            });
                        }
                    }
                });
            }

            $('#input-state').on('change', function () {
                $.ajax({
                    url: '{{route('app.cities')}}',
                    type: "get",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {state: this.value},
                    success: function (response) {
                        if(response && response.length > 0) {
                            $('#input-city').html('');
                            $.each(response, function (index, value) {
                                $('#input-city').append('<option value="' + value.name + '">' + value.name + '</option>');
                            });
                        }
                    }
                })
            });
        });
    </script>
@endsection
