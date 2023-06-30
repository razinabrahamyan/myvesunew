@extends('app.auth.layouts.app')

@section('content')
    <div class="container auth_page">
        <div class="col-12 auth_page_title text-center">
            <h1>ANMELDUNG</h1>
        </div>
        <div class="row justify-content-center">
        <div class="col-12">
            <form method="POST" action="{{route('app.login')}}">
                @csrf

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
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="fcm_token" value="{{$fcm_token}}">
                <input type="hidden" name="lat" value="{{$lat}}">
                <input type="hidden" name="lng" value="{{$lng}}">
                <input type="hidden" name="brand" value="{{$brand}}">

                <div class="form-group row mt-5">
                    <div class="col-md-8 offset-md-4 text-center">
                        <button type="submit" class="btn btn-default btn_auth">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>

                {{--<div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4 text-center forgot_password">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>--}}

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4 text-center auth_register">
                        <a class="btn btn-link" href="{{route('app.register', ["fcm_token" => $fcm_token, "lat" => $lat, "lng" => $lng])}}">
                            {{ __('Register') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection
