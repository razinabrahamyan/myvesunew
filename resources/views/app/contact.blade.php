@extends('app.layouts.app')
@section('title')
    <h5>Contact Us</h5>
@endsection
@section('content')
    <div class="container contact_div animate__animated animate__bounceInLeft">
        <div class="container-fluid pb-3 contact_info">
            <div class="row align-items-center my-2">
                <div class="contact_icon">
                    <i class="fa fa-map-marker-alt"></i>
                </div>
                <div class="ml-2 contact_text">adress</div>
            </div>
            <div class="row align-items-center my-2">
                <div class="contact_icon">
                    <i class="fa fa-phone"></i>
                </div>
                <div class="ml-2 contact_text">
                    <a href="tel:0171 700 4786">0171 700 4786</a> - <a href="tel:0171 707 6974">0171 707 6974</a>
                </div>
            </div>
            <div class="row align-items-center my-2">
                <div class="contact_icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="ml-2 contact_text">info@mayveeu.com</div>
            </div>
        </div>

        <div class="container-fluid pt-3 contact_info_form">
            <form class="shake" role="form" method="POST" id="contactForm" action="{{route("app.contact_us")}}">
                @csrf
                <!-- Name -->
                <div class="form-group label-floating">
                    <label class="control-label" for="name">Username</label>
                    <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="name" type="text" value="{{old("username")}}" name="username">
                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- email -->
                <div class="form-group label-floating">
                    <label class="control-label" for="email">Email</label>
                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" value="{{old("email")}}" name="email" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- Subject -->
                <div class="form-group label-floating">
                    <label class="control-label">Subject</label>
                    <input class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" id="msg_subject" type="text" value="{{old("subject")}}" name="subject" required>
                    @if ($errors->has('subject'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- Message -->
                <div class="form-group label-floating">
                    <label for="message" class="control-label">Message</label>
                    <textarea class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" rows="3" id="message" name="message" required>{{old("message")}}</textarea>
                    @if ($errors->has('message'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- Form Submit -->
                <div class="form-submit mt-5 mb-4">
                    <button class="btn btn-common myvesu_btn" type="submit" id="form-submit"><i class="fa fa-comment"></i> Send Message</button>
                </div>
            </form>
        </div>
    </div>

@endsection
