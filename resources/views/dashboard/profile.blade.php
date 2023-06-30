@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ asset('/uploads/avatar/'.auth()->user()->avatar)}}" height="180" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">

                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">

                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3>
                                {{$user->first_name}} {{$user->last_name}}
                            </h3>


                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i>{{$user->country}} {{$user->state}} {{$user->city}}
                                </div>

                            <hr class="my-4" />
                            @if($user->about)
                                <p>{{$user->about}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">My account</h3>
                            </div>
                            <div class="col-4 text-right"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">User information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Username</label>
                                            <input type="text" id="input-username" class="form-control {{$errors->has('username') ? 'is_invalid' : 'form-control-alternative'}} " placeholder="Username" name="username" value="{{$user->username ?? old('username')}}">
                                            @if ($errors->has('username'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-email">Email address</label>
                                            <input type="email" id="input-email" class="form-control {{$errors->has('email') ? 'is_invalid' : 'form-control-alternative'}} " placeholder="Email" name="email" value="{{$user->email ?? old('email')}}">
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
                                            <input type="text" id="input-first-name" class="form-control {{$errors->has('first_name') ? 'is_invalid' : 'form-control-alternative'}}" placeholder="First name" name="first_name" value="{{$user->first_name ?? old('first_name')}}">
                                            @if ($errors->has('first_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-last-name">Last name</label>
                                            <input type="text" id="input-last-name" class="form-control {{$errors->has('last_name') ? 'is_invalid' : 'form-control-alternative'}}" placeholder="Last name" name="last_name" value="{{$user->last_name ?? old('last_name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-licence_photo">Profile image</label>
                                            <input type="file" id="profile_image" name="profile_image" class="file-upload-default" style="display: none">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info {{ $errors->has('profile_image') ? 'border-danger is-invalid' : 'form-control-alternative' }}" disabled="" placeholder="No file chosen">
                                                <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                            </span>
                                                @if ($errors->has('profile_image'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('profile_image') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Contact information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Address</label>
                                            <input id="input-address" class="form-control {{$errors->has('address') ? 'border-danger is-invalid' : 'form-control-alternative'}}" placeholder="Home Address" name="address" value="{{old('address') ?? $user->address}}" type="text">
                                            @if ($errors->has('address'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-phone">Phone Number</label>
                                            <input id="input-phone" class="form-control {{$errors->has('phone') ? 'border-danger is-invalid' : 'form-control-alternative'}}" placeholder="Phone Number" name="phone" value="{{ old('phone') ?? $user->phone }}" type="tel">
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-country">Country *</label>
                                            <select name="country" id="input-country" class="form-control form-control-alternative {{ $errors->has('country') ? ' is-invalid' : '' }}">
                                                <option value="{{$country->name}}">{{ $country->name }}</option>
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('country') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-state">State *</label>
                                            <select name="state" id="input-state" class="form-control form-control-alternative {{ $errors->has('state') ? ' is-invalid' : '' }}">
                                                <option value="0">Select State</option>
                                                @foreach($country->states as $state)
                                                    <option value="{{$state->name}}" @if (old('state') ?? $user->state == $state->name) selected="selected" @endif>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('state'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('state') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-city">City *</label>
                                            <select name="city" id="input-city" class="form-control form-control-alternative {{ $errors->has('city') ? ' is-invalid' : '' }}">
                                                <option value="{{old('city') ?? $user->city}}">{{old('city') ?? $user->city}}</option>
                                            </select>
                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-zip-code">Zip code</label>
                                            <input type="text" id="input-zip-code" class="form-control form-control-alternative {{ $errors->has('zip') ? ' is-invalid' : '' }}" name="zip" placeholder="Zip code" value="{{ old('zip') ?? $user->zip }}" required>
                                            @if ($errors->has('zip'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('zip') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4" />
                            <!-- Description -->
                            <h6 class="heading-small text-muted mb-4">About me</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="about_me">About Me</label>
                                            <textarea rows="4" id="about_me" name="about" class="form-control  {{ $errors->has('about') ? 'border-danger is-invalid' : 'form-control-alternative' }}" placeholder="A few words about you ...">{{$user->about ?? old('about')}}</textarea>
                                            @if ($errors->has('about'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('about') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">

                </div>

            </div>
        </footer>
    </div>

    <script>
        let cityCode = "{{old('city')}}";
        if(cityCode !== ''){
            let state = $('#input-state').val();
            $.ajax({
                url: '{{route('cities')}}',
                type: "POST",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {state: state},
                success: function (response) {
                    $('#input-city').html('');
                    $.each(response, function( index, value ) {
                        if(Number(cityCode) === value.name){
                            $('#input-city').append('<option value="'+value.name+'">'+value.name+'</option>');
                        }
                    });

                }
            })
        }
        $('#input-state').on('change', function () {
            $.ajax({
                url: '{{route('cities')}}',
                type: "POST",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {state: this.value},
                success: function (response) {
                    $('#input-city').html('');
                    $.each(response, function( index, value ) {
                        $('#input-city').append('<option value="'+value.name+'">'+value.name+'</option>');
                    });

                }
            })
        });
    </script>
@endsection
