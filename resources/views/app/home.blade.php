@extends('app.auth.layouts.app')

@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <div class="col-12">
                <h1>SHARE A RIDE</h1>
                <p class="intro_text">Single ride and/or repeatable scheduled rides. Find out who else is willing to share a ride with you.</p>
                <div class="row">
                    <div class="col-12">
                        <a class="intro_button" href="{{route('app.own.rides')}}" >VIEW EXISTING RIDES</a>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5">
                <h1>SHARE A RIDE</h1>
                <p class="intro_text">Customize your ride and use it at once or pre-book and schedule it for your weekly/monthly routine!</p>
                <div class="row">
                    <div class="col-12">
                        <a class="intro_button_default" href="{{route('app.booking')}}" >BOOK NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
