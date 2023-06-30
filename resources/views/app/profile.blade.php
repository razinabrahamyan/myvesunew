@extends('app.layouts.app')


@section('title')
    <h5>PROFILE</h5>
@endsection

@section('content')
    <div class="container-fluid" id="users_image_div">
        <img src="{{asset('uploads/avatar/'.Auth::user()->avatar)}}" >
        <div class="container users_absolute_place">
            <div class="row users_info_place justify-content-between p-2 align-items-end">
                <div class="col-5 users_profile_name">
                    <p>{{Auth::user()->first_name}}</p>
                    <p>{{Auth::user()->last_name}}</p>
                </div>
                <div class="col-6 users_profile_since">
                    <p>user since</p>
                    <p>{{Carbon\Carbon::parse(Auth::user()->created_at)->format("Y M d")}}</p>
                </div>
            </div>
        </div>
        <div class="profile_edit_div">
            <a href="{{route('app.profile.edit')}}">
                <i class="fa fa-edit"></i>
            </a>
        </div>
    </div>

    <div class="container-fluid profile_address_div pt-1 mt-1">
        <h3>About</h3>
        @if(Auth::user()->about)
        <p class="pb-3 mb-1">{{Auth::user()->about}}</p>
        @else
            <p class="pb-1 mb-1">No info</p>
        @endif
    </div>
    <div class="container-fluid profile_address_div pt-1">
        <h3>Address</h3>
        <p class="pb-2 mb-1">{{Auth::user()->address}}</p>
    </div>
    @if(auth()->user()->hasRole('driver'))
    <div class="container-fluid profile_address_div pt-1">
        <h3>Rating</h3>
        @if(Auth::user()->driver->rating)
            <p class="pb-3 orange_text">{{substr(Auth::user()->driver->rating,0,3)}}</p>
        @else
            <p class="pb-3">No Rating</p>
        @endif
    </div>
    @endif
    <div class="container-fluid profile_user_city pt-1">
        <div class="row">
            <div class="col-6">
                <h3>City</h3>
                <p class="mb-1">{{Auth::user()->city}}</p>
            </div>
            <div class="col-6">
                <h3>Country</h3>
                <p class="mb-1">{{Auth::user()->country}}</p>
            </div>
            <div class="col-6">
                <h3>Contact</h3>
                <p class="mb-1">{{Auth::user()->phone}}</p>
            </div>
            <div class="col-6">
                <h3>Email</h3>
                <p class="mb-1">{{Auth::user()->email}}</p>
            </div>
        </div>
    </div>
    <!-- The core Firebase JS SDK is always required and must be listed first -->


    <script type="text/javascript">


    </script>
@endsection

