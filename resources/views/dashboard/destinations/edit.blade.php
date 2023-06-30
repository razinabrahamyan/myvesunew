@extends('dashboard.layouts.app')

@section('content')
    <div class="modal fade bd-example-modal-lg"  id="modal_loader">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <img width="60" height="60" src="{{asset("/assets/img/brand/loader.gif")}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="heading-small text-muted mb-4">Edit Destination</h6>
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
                    <form method="POST" id="ride_update_form" action="{{route('destination.update',$destination->id)}}">
                        @csrf
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="address">Address*</label>
                                        <input type="text" id="address" name="address" class="form-control" placeholder="type address" value="{{ $destination->address ?? old('address') }}" required>
                                        <span class="invalid-feedback pick_up_feedback d-block text-center" role="alert"></span>
                                    </div>
                                    <input type="hidden" value="{{$destination->lat}}" id="destination_lat" name="destination_lat">
                                    <input type="hidden" value="{{$destination->lng}}" id="destination_lng" name="destination_lng">
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <hr class="my-4"/>
                        </div>
                        <div class="col-lg-6 text-center">
                            <a href="{{route('dashboard.destinations')}}" class="btn btn-default ">Cancel</a>
                            <button type="submit" class="btn btn-primary update_ride">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv20gVp7XEbDy4OTN0Sxod2iuEKJjfYeo&libraries=places&callback=initAutocomplete" async defer></script>

    <script type="text/javascript">
        function initAutocomplete() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input, {types: ['geocode']});
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                document.getElementById('destination_lat').value = latitude;
                document.getElementById('destination_lng').value = longitude;
            })

        }

    </script>
@endsection
