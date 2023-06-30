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
                                    <img src="{{asset('uploads/avatar/'.$user->avatar)}}" class="img-thumbnail rounded d-block mx-auto" alt="">
                                </div>
                                <a href="{{route('passenger.edit',$user->id)}}" class="btn d-block mt-2 border rounded dashboard_edit_link">Edit <i class="fa fa-edit"></i></a>
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
                                        @if($user->username)
                                            {{$user->username}}
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
                                        @if($user->first_name)
                                            {{$user->first_name}}
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
                                        @if($user->last_name)
                                            {{$user->last_name}}
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
                                        @if($user->about)
                                            {{$user->about}}
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
                                        @if($user->email)
                                            {{$user->email}}
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
                                        @if($user->phone)
                                            {{$user->phone}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>

                            </div>

     <!--//*********************************************************************************************************************************************************************************-->
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
                                        @if($user->address)
                                            {{$user->address}}
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
                                        @if($user->country)
                                            {{$user->country}}
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
                                        @if($user->state)
                                            {{$user->state}}
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
                                        @if($user->city)
                                            {{$user->city}}
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
                                        {{$user->id}}
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
                                        @if($user->blocked === '1') <span class="blocked_user">blocked</span> @else <span class="active_user">active</span> @endif
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
                                        @if($user->created_at)
                                            {{Carbon\Carbon::parse($user->created_at)->format("d M o h:i A")}}
                                        @else
                                            <span class="">no info</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
<!--//*********************************************************************************************************************************************************************************-->


                            <div class="col-lg-6 pl-2 pt-2 border">
                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Company
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-briefcase"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Company Name
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8col-md-6 col-6 passenger_view_values border-left">
                                        @if($user->passenger->company_name)
                                            {{$user->passenger->company_name}}
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
                                                Company Address
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8col-md-6 col-6 passenger_view_values border-left">
                                        @if($user->passenger->company_address)
                                            {{$user->passenger->company_address}}
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
                                                Cost Unit
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8col-md-6 col-6 passenger_view_values border-left">
                                        @if($user->passenger->cost_unit)
                                            {{$user->passenger->cost_unit}}
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
                                                Free Text
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8col-md-6 col-6 passenger_view_values border-left">
                                        @if($user->passenger->free_text)
                                            {{$user->passenger->free_text}}
                                        @else
                                            <span class="">no info</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
<!--//*********************************************************************************************************************************************************************************-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
