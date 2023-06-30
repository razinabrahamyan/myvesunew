@extends('app.auth.layouts.app')

@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="{{asset('../assets/img/brand/logo.png')}}" alt="MyVesu" height="100">
            <p class="lead start_text">myvesu ist ein professionelles Dienstleistungsunternehmen, das sich auf die zuverlässige und sichere Beförderung von Einzelpersonen und Gruppen spezialisiert hat. Und das im gesamten Rhein-Main-Gebiet.</p>
            <div class="row">
            <div class="col-12 start_button_col">
                <a class="start_button" href="{{route('app.loginform', ["fcm_token" => $fcm_token, "lat" => $lat, "lng" => $lng,'brand'=> $brand])}}" >START</a>
            </div>
            </div>
        </div>
    </div>
@endsection
