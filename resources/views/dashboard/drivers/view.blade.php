@extends('dashboard.layouts.app')

@section('content')
    <div class="container mt--7">
        <div class="row justify-content-center">
            <div class="col-lg-12 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="container-fluid">
                        <div class="row flex-wrap py-4 passenger_view_div">
                            <div class="col-lg-6 col-12 pl-2 pt-2">
                                <div>
                                    <img src="{{asset('uploads/avatar/'.$driver->avatar)}}" class="img-thumbnail rounded " alt="">
                                </div>
                                <a href="{{route('driver.edit',$driver->id)}}" class="btn d-block mt-2 border rounded dashboard_edit_link">Edit <i class="fa fa-edit"></i></a>
                            </div>

                            <!--//****************************************************************************************************************************************************************-->
                            <div class="col-lg-6 pl-2 pt-2 border">
                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Personal
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Username
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->username)
                                            {{$driver->username}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                First Name
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->first_name)
                                            {{$driver->first_name}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Last Name
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->last_name)
                                            {{$driver->last_name}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                About
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->about)
                                            {{$driver->about}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Contact
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Email
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->email)
                                            {{$driver->email}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Phone
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->phone)
                                            {{$driver->phone}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--//****************************************************************************************************************************************************************-->
                            <div class="col-lg-6 pl-2 pt-2 border">
                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Address
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-map-marker-alt"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Address
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->address)
                                            {{$driver->address}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Country
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->country)
                                            {{$driver->country}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                State
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->state)
                                            {{$driver->state}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                City
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->city)
                                            {{$driver->city}}
                                        @else
                                            <span class="">no info</span>
                                        @endif

                                    </div>
                                </div>

                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Account
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-id-card"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                ID
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        {{$driver->id}}
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Driver ID
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        {{$driver->driver()->first()->id}}
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-info-circle"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Status
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->blocked === '1') <span class="blocked_user">blocked</span> @else <span class="active_user">active</span> @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-calendar-alt"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Created
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->created_at)
                                            {{Carbon\Carbon::parse($driver->created_at)->format("d M o h:i A")}}
                                        @else
                                            <span class="">no info</span>
                                        @endif

                                    </div>
                                </div>

                            </div>
                            <!--//****************************************************************************************************************************************************************-->

                            <div class="col-lg-6 pl-2 pt-2 border">
                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Driver
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-id-badge"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                License number
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->licence_number)
                                            {{$driver->driver()->first()->licence_number}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Rating
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->rating)
                                            {{$driver->driver()->first()->rating}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Car
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-car"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Type
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->type)
                                            {{$driver->driver()->first()->cars()->first()->type}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Make
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->make)
                                            {{$driver->driver()->first()->cars()->first()->make}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Model
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->model)
                                            {{$driver->driver()->first()->cars()->first()->model}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Year
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->year)
                                            {{$driver->driver()->first()->cars()->first()->year}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-palette"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Color
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->color)
                                            {{$driver->driver()->first()->cars()->first()->color}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-user-friends"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Passengers
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->number_of_passenger)
                                            {{$driver->driver()->first()->cars()->first()->number_of_passenger}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-suitcase-rolling"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Suitcases
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->number_of_suitcases)
                                            {{$driver->driver()->first()->cars()->first()->number_of_suitcases}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-child"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Baby Seat
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->baby_booster_seat === '0')
                                            no
                                        @else
                                            yes
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Registration
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->vehicle_registration_number)
                                            {{$driver->driver()->first()->cars()->first()->vehicle_registration_number}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div class="col-9 border-left">
                                                Additional
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($driver->driver()->first()->cars()->first()->additional_info)
                                            {{$driver->driver()->first()->cars()->first()->additional_info}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!--//****************************************************************************************************************************************************************-->

                            <div class="col-lg-6 pl-2 pt-2 ">
                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Vehicle photo
                                    </div>
                                </div>
                                <div class="row  flex-column">
                                    <div class="col-12 passenger_view_values ">
                                        <div>
                                            <img src="{{asset('uploads/vehicle/'.$driver->driver()->first()->cars()->first()->vehicle_photo)}}" class="img-thumbnail rounded " alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--//****************************************************************************************************************************************************************-->

                            <div class="col-lg-6 pl-2 pt-2 ">
                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        License photo
                                    </div>
                                </div>
                                <div class="row  flex-column">
                                    <div class="col-12 passenger_view_values ">
                                        <div>
                                            <img src="{{asset('uploads/licence/'.$driver->driver()->first()->licence_photo)}}" class="img-thumbnail rounded " alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--//****************************************************************************************************************************************************************-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

