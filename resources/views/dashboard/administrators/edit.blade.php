@extends('dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="heading-small text-muted mb-4">Edit Administrator information</h6>
                    @if (session('success'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger text-center" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('administrator.update', $administrator)}}">
                        @csrf
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Username *</label>
                                        <input type="text" id="input-username" name="username" class="form-control form-control-alternative {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" value="{{$administrator->username ? $administrator->username :""}}" required>
                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address *</label>
                                        <input type="email" id="input-email" name="email" class="form-control form-control-alternative" placeholder="Email address" value="{{$administrator->email ? $administrator->email : ""}}" required>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">First name</label>
                                        <input type="text" id="input-first-name"  name="first_name" class="form-control form-control-alternative" placeholder="First name" value="{{$administrator->first_name ? $administrator->first_name: ""}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Last name</label>
                                        <input type="text" id="input-last-name"  name="last_name" class="form-control form-control-alternative" placeholder="Last name" value="{{$administrator->last_name ? $administrator->last_name : ""}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-role">Role</label>
                                        <select  name="role" id="input-role" class="form-control form-control-alternative">
                                            <option value="6" @if($administrator->hasRole('user')) selected @endif>User</option>
                                            <option value="2" @if($administrator->hasRole('admin')) selected @endif>Administrator</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-control-label" for="status">Status (Unblock/Block)</label>
                                    <div class="form-group">
                                        <label class="custom-toggle mt-2 ">
                                            <input class="status" name="blocked" value="1" type="checkbox"@if($administrator->blocked == 1) checked @endif>
                                            <span class="custom-toggle-slider rounded-circle"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-5">
                        <div class="col-lg-12 text-center">
                            <a href="{{route('administrators')}}" class="btn btn-default ">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
