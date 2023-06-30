@extends('dashboard.layouts.app')

@section('content')
    <div class="container mt--7">
        <div class="row justify-content-center">
            <div class="col-lg-10 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 ml-lg--4">
                            <div class="card-profile-image">
                                <img src="{{ asset('/uploads/avatar/'.$admin->avatar)}}" height="180" class="rounded-circle">
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0 pt-md-4 mt-5 ml--3">
                        <div class="text-center mt-7">
                            <div class="h5 font-weight-400">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-5 text-left offset-lg-1">
                                                <span class="h4">Username: </span>
                                            </div>
                                            <div class="col-lg-6 text-left">
                                                <span class="h5 text-blue">{{$admin->username}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="h5 font-weight-400">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-5 text-left offset-lg-1">
                                                <span class="h4">First name: </span>
                                            </div>
                                            <div class="col-lg-6 text-left">
                                                <span class="h5 text-blue">{{$admin->first_name}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="h5 font-weight-400">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-5 text-left offset-lg-1">
                                                <span class="h4">Last name: </span>
                                            </div>
                                            <div class="col-lg-6 text-left">
                                                <span class="h5 text-blue">{{$admin->last_name}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="h5 font-weight-400">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-5 text-left offset-lg-1">
                                                <span class="h4">Email: </span>
                                            </div>
                                            <div class="col-lg-6 text-left">
                                                <span class="h5 text-blue">{{$admin->email}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($admin->country !=null && $admin->city !=null)
                                <div class="h5 font-weight-400">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-lg-5 text-left offset-lg-1">
                                                    <span class="h4">City/Country: </span>
                                                </div>
                                                <div class="col-lg-6 text-left">
                                                    <span class="h5 text-blue">{{$admin->city}} , {{$admin->country}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="h5 font-weight-400">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-5 text-left offset-lg-1">
                                                <span class="h4">Role: </span>
                                            </div>
                                            <div class="col-lg-6 text-left">
                                                <span class="h5 text-blue">
                                                    @if($admin->hasRole('user')) User @endif
                                                    @if($admin->hasRole('admin')) Administrator @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="h5 font-weight-400">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-5 text-left offset-lg-1">
                                                <span class="h4">Status: </span>
                                            </div>
                                            <div class="col-lg-6 text-left">
                                                <span class="h5 text-blue">@if($admin->blocked == 1) Blocked @else Unblocked @endif</span>
                                            </div>
                                        </div>
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
