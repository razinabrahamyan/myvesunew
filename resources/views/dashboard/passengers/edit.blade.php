@extends('dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="heading-small text-muted mb-4">Edit passenger information</h6>
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
                    <form method="POST" action="{{route('passenger.update', $user->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Username *</label>
                                        <input type="text" id="input-username" name="username" class="form-control form-control-alternative {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" value="{{ $user->username ?? old('username') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address *</label>
                                        <input type="email" id="input-email" name="email" class="form-control form-control-alternative {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email address" value="{{ $user->email ?? old('email') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">First name *</label>
                                        <input type="text" id="input-first-name" name="first_name" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : 'form-control-alternative' }}" placeholder="First name" value="{{$user->first_name ?? old('first_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Last name *</label>
                                        <input type="text" id="input-last-name" name="last_name" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : 'form-control-alternative' }}" placeholder="Last name" value="{{$user->last_name ?? old('last_name') }}" required>
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-about">About Passenger</label>
                                        <textarea id="input-about" class="form-control form-control-alternative" placeholder="About Passenger" name="about">{{$user->about ?? old('about')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4"/>
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Contact information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">Phone <span class="text-danger">*</span></label>
                                        <input id="input-phone" class="form-control {{ $errors->has('phone') ? 'border-danger is-invalid' : 'form-control-alternative ' }}" placeholder="Phone" name="phone" value="{{$user->phone ?? old('phone')}}" type="tel" required>
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
                                        <input id="input-address" class="form-control {{ $errors->has('address') ? 'border-danger is-invalid' : 'form-control-alternative' }}" placeholder="Home Address" name="address" value="{{$user->address ?? old('address')}}" type="text" required>
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
                                            @foreach($states as $state)
                                                <option value="{{$state->name}}" @if ($user->state == $state->name) selected="selected" @endif>{{$state->name}}</option>
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
                                            <option value="{{$user->city}}">{{$user->city}}</option>
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
                                        <input type="text" id="input-zip-code" class="form-control form-control-alternative {{ $errors->has('zip') ? ' is-invalid' : '' }}" name="zip" placeholder="Zip code" value="{{ $user->zip }}" required>
                                        @if ($errors->has('zip'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('zip') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                            <hr class="my-4"/>
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Additional information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="company_name">Company name</label>
                                            <input type="text" id="company_name" class="form-control {{ $errors->has('company_name') ? 'border-danger is-invalid' : ' form-control-alternative' }}" name="company_name" placeholder="Company name" value="{{$passenger->company_name ?? old('company_name')}}">
                                            @if ($errors->has('company_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('company_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="company_address">Company address</label>
                                            <input type="text" id="company_address" class="form-control  {{ $errors->has('company_address') ? 'border-danger is-invalid' : 'form-control-alternative' }}" name="company_address" placeholder="Company address" value="{{$passenger->company_address ??  old('company_address')}}">
                                            @if ($errors->has('company_address'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('company_address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="cost_unit">Cost Unit</label>
                                            <input type="text" id="cost_unit" class="form-control {{ $errors->has('cost_unit') ? 'border-danger is-invalid' : 'form-control-alternative' }}" name="cost_unit" placeholder="Company address" value="{{$passenger->cost_unit ??  old('cost_unit')}}">
                                            @if ($errors->has('cost_unit'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cost_unit') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="free_text">Free Text <span class="text-danger">*</span></label>
                                            <input type="text" id="free_text" class="form-control {{ $errors->has('free_text') ? 'border-danger is-invalid' : 'form-control-alternative' }}" name="free_text" placeholder="Company address" value="{{$passenger->free_text ?? old('free_text')}}">
                                            @if ($errors->has('free_text'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('free_text') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4"/>
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
        let cityCode = "{{old('city')}}";
        if (cityCode !== '') {

            let state = $('#input-state').val();
            console.log(state);
            $.ajax({
                url: '{{route('cities')}}',
                type: "POST",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {state: state},
                success: function (response) {
                    console.log(response);
                    $('#input-city').html('');
                    $.each(response, function (index, value) {
                        if (Number(cityCode) === value.id) {
                            $('#input-city').append('<option value="' + value.name + '">' + value.name + '</option>');
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
                    $.each(response, function (index, value) {
                        $('#input-city').append('<option value="' + value.name + '">' + value.name + '</option>');
                    });

                }
            })
        });

    </script>
@endsection
