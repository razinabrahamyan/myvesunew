@extends('dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="heading-small text-muted mb-4">Edit Driver information</h6>
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
                    <form method="POST" action="{{route('driver.update', $driver)}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="driver_id" value="{{$driver->driver()->first()->id}}">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-control-label" for="status">Status (Unblock/Block)</label>
                                    <div class="form-group">
                                        <label class="custom-toggle mt-2 ">
                                            <input class="status" name="blocked" value="1" type="checkbox"@if($driver->blocked == 1) checked @endif>
                                            <span class="custom-toggle-slider rounded-circle"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Username *</label>
                                        <input type="text" id="input-username" name="username" class="form-control form-control-alternative {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" value="{{ $driver->username }}" required>
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
                                        <input type="email" id="input-email" name="email" class="form-control form-control-alternative {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email address" value="{{ $driver->email }}" required>
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
                                        <label class="form-control-label" for="input-first-name">First name *</label>
                                        <input type="text" id="input-first-name"  name="first_name" class="form-control form-control-alternative {{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="First name" value="{{ $driver->first_name }}" required>
                                        @if ($errors->has('first_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Last name *</label>
                                        <input type="text" id="input-last-name"  name="last_name" class="form-control form-control-alternative {{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="Last name" value="{{ $driver->last_name }}" required>
                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-about">About Driver</label>
                                        <textarea id="input-about" class="form-control form-control-alternative" placeholder="About Driver" name="about">{{ $driver->about }}</textarea>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4" />
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Contact information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">Phone *</label>
                                        <input id="input-phone" class="form-control form-control-alternative {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Phone" name="phone" value="{{ $driver->phone }}" type="tel" required>
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Address *</label>
                                        <input id="input-address" class="form-control form-control-alternative {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Home Address" name="address" value="{{ $driver->address }}" type="text" required>
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-country">Country *</label>
                                        <select  name="country" id="input-country" class="form-control form-control-alternative {{ $errors->has('country') ? ' is-invalid' : '' }}">
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
                                        <select  name="state" id="input-state" class="form-control form-control-alternative {{ $errors->has('state') ? ' is-invalid' : '' }}">
                                            <option value="0">Select State</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->name}}" @if ($driver->state == $state->name) selected="selected" @endif>{{$state->name}}</option>
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
                                        <select  name="city" id="input-city" class="form-control form-control-alternative {{ $errors->has('city') ? ' is-invalid' : '' }}">
                                            <option value="{{$driver->city}}" >{{$driver->city}}</option>
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
                                        <input type="text" id="input-zip-code" class="form-control form-control-alternative {{ $errors->has('zip') ? ' is-invalid' : '' }}" name="zip" placeholder="Zip code" value="{{ $driver->zip }}" required>
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
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Vehicle information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-type">Type *</label>
                                        <select  name="type" id="input-type" class="form-control form-control-alternative {{ $errors->has('type') ? ' is-invalid' : '' }}">
                                            <option value="0" >Select Type</option>
                                            @foreach($vehicle_typs as $type)
                                                <option value="{{$type->name}}" @if ($driver->driver()->first()->cars()->first()->type == $type->name) selected="selected" @endif>{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('type'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-make">Make *</label>
                                        <select  name="make" id="input-make" class="form-control form-control-alternative {{ $errors->has('make') ? ' is-invalid' : '' }}">
                                            <option value="0" >Select Make</option>
                                            @foreach($vehicle_makes as $make)
                                                <option value="{{$make->name}}" @if ($driver->driver()->first()->cars()->first()->make == $make->name) selected="selected" @endif>{{$make->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('make'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('make') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-model">Model *</label>
                                        <select  name="model" id="input-model" class="form-control form-control-alternative {{ $errors->has('model') ? ' is-invalid' : '' }}">
                                            <option value="{{$driver->driver()->first()->cars()->first()->model}}" >{{$driver->driver()->first()->cars()->first()->model}}</option>
                                        </select>
                                        @if ($errors->has('model'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('model') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-year">Year *</label>
                                        <select  name="year" id="input-year" class="form-control form-control-alternative {{ $errors->has('year') ? ' is-invalid' : '' }}">
                                            <option value="0" >Select Year</option>
                                            @for ($year=now()->year; $year >= 1990; $year--)
                                                <option value="{{$year}}" @if($driver->driver()->first()->cars()->first()->year == $year) selected="selected" @endif>{{$year}}</option>
                                            @endfor
                                        </select>
                                        @if ($errors->has('year'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('year') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-color">Color *</label>
                                        <select  name="color" id="input-color" class="form-control form-control-alternative {{ $errors->has('color') ? ' is-invalid' : '' }}">
                                            <option value="0" >Select Color</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'white') selected="selected" @endif value="white" style="color: black">White</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'black') selected="selected" @endif style="background: black; color: white" value="black">Black</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'silver') selected="selected" @endif style="background: silver; color: black" value="silver">Silver</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'gray') selected="selected" @endif style="background: gray; color: white" value="gray">Gray</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'red') selected="selected" @endif style="background: red; color: white" value="red">Red</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'blue') selected="selected" @endif style="background: blue; color: white" value="blue">Blue</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'brown') selected="selected" @endif style="background: brown; color: white" value="brown">Brown</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'yellow') selected="selected" @endif style="background: yellow; color: black" value="yellow">Yellow</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'green') selected="selected" @endif style="background: green; color: white" value="green">green</option>
                                            <option @if($driver->driver()->first()->cars()->first()->color == 'other') selected="selected" @endif value="other">Other</option>
                                        </select>
                                        @if ($errors->has('color'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('color') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-number_of_passenger">Number of passenger *</label>
                                        <input type="number" id="input-number_of_passenger" class="form-control form-control-alternative {{ $errors->has('number_of_passenger') ? ' is-invalid' : '' }}" name="number_of_passenger" placeholder="Number of passenger" value="{{ $driver->driver()->first()->cars()->first()->number_of_passenger }}" required>
                                        @if ($errors->has('number_of_passenger'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('number_of_passenger') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-number_of_suitcases">Number of suitcases *</label>
                                        <input type="number" id="input-number_of_suitcases" class="form-control form-control-alternative {{ $errors->has('number_of_suitcases') ? ' is-invalid' : '' }}" name="number_of_suitcases" placeholder="Number of suitcases" value="{{ $driver->driver()->first()->cars()->first()->number_of_suitcases }}" required>
                                        @if ($errors->has('number_of_suitcases'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('number_of_suitcases') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-licence_number">Licence Number *</label>
                                        <input type="text" id="input-licence_number" class="form-control form-control-alternative {{ $errors->has('licence_number') ? ' is-invalid' : '' }}" name="licence_number" placeholder="Licence Number" value="{{ $driver->driver()->first()->licence_number }}" required>
                                        @if ($errors->has('licence_number'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('licence_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-vehicle_registration_number">Registration number of the vehicle *</label>
                                        <input type="text" id="input-vehicle_registration_number" class="form-control form-control-alternative {{ $errors->has('vehicle_registration_number') ? ' is-invalid' : '' }}" name="vehicle_registration_number" placeholder="Registration number of the vehicle" value="{{ $driver->driver()->first()->cars()->first()->vehicle_registration_number }}" required>
                                        @if ($errors->has('vehicle_registration_number'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('vehicle_registration_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-color">Baby Booster Seat</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="baby_booster_seat" id="baby_booster_seat" value="1" @if($driver->driver()->first()->cars()->first()->baby_booster_seat == '1') checked @endif>
                                            <label class="form-check-label" for="baby_booster_seat">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="baby_booster_seat" id="baby_booster_seat2" value="0" @if($driver->driver()->first()->cars()->first()->baby_booster_seat == '0') checked @endif>
                                            <label class="form-check-label" for="baby_booster_seat2">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-additional_info">Additional information</label>
                                        <textarea id="input-additional_info" class="form-control form-control-alternative {{ $errors->has('additional_info') ? ' is-invalid' : '' }}" placeholder="Additional information" name="additional_info">{{ $driver->driver()->first()->cars()->first()->additional_info }}</textarea>
                                        @if ($errors->has('additional_info'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('additional_info') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-licence_photo">Licence Photo *</label>
                                        <input type="file" id="licence_photo" name="licence_photo" class="file-upload-default" value="{{$driver->driver()->first()->licence_photo}}" style="display: none">
                                        <input type="hidden" name="old_licence_photo" value="{{$driver->driver()->first()->licence_photo}}">
                                        <div class="input-group col-xs-12 mt-2 mb-2">
                                            <img id="image" src="{{ asset('/uploads/licence/'.$driver->driver()->first()->licence_photo)}}"  class="img-rounded" width="100%" height="200">
                                        </div>
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info {{ $errors->has('licence_photo') ? ' is-invalid' : '' }}" disabled="" placeholder="No file chosen">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                            </span>
                                            @if ($errors->has('licence_photo'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('licence_photo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-vehicle_photo">Vehicle Photo</label>
                                        <input type="file" id="vehicle_photo" name="vehicle_photo" class="file-upload-default" value="{{$driver->driver()->first()->cars()->first()->vehicle_photo}}" style="display: none">
                                        <input type="hidden" name="old_vehicle_photo" value="{{$driver->driver()->first()->cars()->first()->vehicle_photo}}">
                                        <div class="input-group col-xs-12 mt-2 mb-2">
                                            <img id="image" src="{{ asset('/uploads/vehicle/'.$driver->driver()->first()->cars()->first()->vehicle_photo)}}"  class="img-rounded" width="100%" height="200">
                                        </div>
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info {{ $errors->has('vehicle_photo') ? ' is-invalid' : '' }}" disabled="" placeholder="No file chosen">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                            </span>
                                            @if ($errors->has('vehicle_photo'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('vehicle_photo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4" />
                        </div>
                        <div class="col-lg-12 text-center">
                            <a href="{{route('drivers.list')}}" class="btn btn-default ">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
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
                    if(response && response.length > 0) {
                        $('#input-city').html('');
                        $.each(response, function (index, value) {
                            $('#input-city').append('<option value="' + value.name + '">' + value.name + '</option>');
                        });
                    }
                }
            })
        });

        $('#input-make').on('change', function () {
            $.ajax({
                url: '{{route('models')}}',
                type: "POST",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {make: this.value},
                success: function (response) {
                    if(response && response.length > 0) {
                        $('#input-model').html('');
                        $.each(response, function (index, value) {
                            $('#input-model').append('<option value="' + value.name + '">' + value.name + '</option>');
                        });
                    }
                }
            });
        });
    </script>
@endsection

