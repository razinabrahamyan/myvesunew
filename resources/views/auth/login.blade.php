@extends('dashboard.layouts.auth_app')
@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">Login</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">

                        <div class="text-center text-muted mb-4">
                            <a href="/dashboard">
                                <img src="{{asset('/assets/img/brand/myvesu_logo.png')}}" height="70px">
                            </a>
                        </div>
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" type="email" value="{{ old("email") }}" name="email" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    @if (session('error'))
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ session('error') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Password" type="password" name="password">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning my-4">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="{{ route('password.request') }}" class="text-white"><small>{{ __('Forgot Your Password?') }}</small></a>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{route('register')}}" class="text-white"><small>Create new account</small></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
