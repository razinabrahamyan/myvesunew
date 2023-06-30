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
                                    <img src="{{asset('uploads/rides/'.$ride->image)}}" class="img-thumbnail rounded d-block mx-autod" alt="">
                                </div>
                                <a href="{{route('ride.edit',$ride->id)}}" class="btn d-block mt-2 border rounded dashboard_edit_link">Edit <i class="fa fa-edit"></i></a>
                            </div>



                            <!--//****************************************************************************************************************************************************************-->
                            <div class="col-lg-6 pl-2 pt-2 border">
                                <div class="border-bottom py-2 passenger_view_heading">
                                    <div class="container">
                                        Who opened
                                    </div>
                                </div>
                                <a @if($ride->type === 'passenger') href="{{route('passenger.view',$ride->user->id)}}" @else href="{{route('driver.view',$ride->user->id)}}" @endif >
                                    <div class="row border-bottom border m-2 p-2 align-items-center">
                                        <div class="col-2 ride_user_image" ><img src="{{asset('uploads/avatar/'.$ride->user->avatar)}}" class="img-fluid rounded ride_user_image"></div>
                                        <div class="col-10">{{$ride->user->first_name.' '.$ride->user->last_name}}</div>
                                    </div>
                                </a>
                                <div class="border-bottom py-2 passenger_view_heading">
                                    <div class="container">
                                        Driver
                                    </div>
                                </div>
                                @if($ride->driver)
                                <a href="{{route('driver.view',$ride->driver->id)}}">
                                    <div class="row border-bottom border m-2 p-2 align-items-center">
                                        <div class="col-2 ride_user_image" ><img src="{{asset('uploads/avatar/'.$ride->driver->avatar)}}" class="img-fluid rounded ride_user_image"></div>
                                        <div class="col-10">{{$ride->driver->first_name.' '.$ride->driver->last_name}}</div>
                                    </div>
                                </a>
                                @else
                                    <div class="row m-2 p-2 align-items-center">
                                        <span>no driver</span>
                                    </div>
                                @endif


                                <div class="border-bottom py-2 passenger_view_heading">
                                    <div class="container">
                                        Passengers Joined ({{$ride->passengers()->count().'/'.$count}})
                                    </div>
                                </div>
                                <div class="ride_passengers_div nice_scroll mt-3">
                                    @foreach($ride->passengers()->get() as $passenger)
                                        <a href="{{route('passenger.view',$passenger->id)}}">
                                            <div class="row border-bottom border m-2 p-2 align-items-center">
                                                <div class="col-2 ride_user_image" ><img src="{{asset('uploads/avatar/'.$passenger->avatar)}}" class="img-fluid rounded ride_user_image"></div>
                                                <div class="col-10">{{$passenger->first_name.' '.$passenger->last_name}}</div>
                                            </div>

                                        </a>

                                    @endforeach
                                </div>

                            </div>
                            <!--//*********************************************************************************************************************************************************************************-->
                            <div class="col-lg-6 pl-2 pt-2 border">
                                <div class="border-bottom py-3 passenger_view_heading">
                                    <div class="container">
                                        Info
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
                                        @if($ride->baby_seat === '0')
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
                                                <i class="fa fa-suitcase-rolling"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Suitcases
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($ride->suitcase)
                                            {{$ride->suitcase}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
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
                                        @if($ride->created_at)
                                            {{Carbon\Carbon::parse($ride->created_at)->format("d M o h:i A")}}
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
                                                Date
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8col-md-6 col-6 passenger_view_values border-left">
                                        @if($ride->date)
                                            {{Carbon\Carbon::parse($ride->date)->format("d M o")}}
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
                                                Time
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8col-md-6 col-6 passenger_view_values border-left">
                                        @if($ride->time)
                                            {{Carbon\Carbon::parse($ride->time)->format("h:i A")}}
                                        @else
                                            <span class="">no info</span>
                                        @endif

                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-info-circle"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Additional
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($ride->info)
                                            {{$ride->info}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-lg-6 col-xl-4 col-md-6 col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <i class="fa fa-map-marker-alt"></i>
                                            </div>
                                            <div class="col-9 border-left">
                                                Pick up point
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-8 col-md-6 col-6 passenger_view_values border-left">
                                        @if($ride->pick_up)
                                            {{$ride->pick_up}}
                                        @else
                                            <span class="">no info</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
