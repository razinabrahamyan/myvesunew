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
                    <h6 class="heading-small text-muted mb-4">Edit Ride</h6>
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
                    <form method="POST" id="ride_update_form">
                        @csrf
                        <div class="pl-lg-4">

                            <div class="row">
                                <div class="col-lg-6 custom-datepicker" id="edit_ride_date">
                                    <div class="form-group">
                                        <label class="form-control-label" for="date">Date</label>
                                        <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                            <input id="date" name="date" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" value="{{$ride->date ?? old('date')}}" required readonly/>
                                            <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback date_feedback d-block text-center" role="alert"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 custom-timepicker" id="edit_ride_time">
                                    <div class="form-group">
                                        <label class="form-control-label" for="time">Time</label>
                                        <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                            <input id="time" name="time" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" value="{{$ride->time ?? old('time')}}" required readonly/>
                                            <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                            </div>
                                            <span class="invalid-feedback time_feedback d-block text-center" role="alert"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="pick_up">Pick up *</label>
                                        <input type="text" id="pick_up" name="pick_up" class="form-control" placeholder="Pick up" value="{{ $ride->pick_up ?? old('pick_up') }}" required>
                                        <span class="invalid-feedback pick_up_feedback d-block text-center" role="alert"></span>
                                    </div>
                                    <input type="hidden" value="{{$ride->pick_up_lat}}" id="pickup_point_lat" name="pickup_point_lat">
                                    <input type="hidden" value="{{$ride->pick_up_lng}}" id="pickup_point_lng" name="pickup_point_lng">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="destination">Destination *</label>
                                        <select name="destination" id="destination" class="form-control" required>
                                            @foreach($destinations as $destination)
                                                <option value="{{$destination->id}}" {{$ride->destination == $destination->id? 'selected':''}}>{{$destination->address}}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback destination_feedback d-block text-center" role="alert"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="price">Price *</label>
                                        <input type="number" id="price" name="price" class="form-control" placeholder="Price" value="{{ $ride->price ?? old('price') }}" required>
                                        <span class="invalid-feedback price_feedback d-block text-center" role="alert"></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="passengers">Passengers *</label>
                                        <input type="number" id="passengers" name="passengers" class="form-control" placeholder="Passengers" value="{{ $ride->passengers ?? old('passengers') }}" required>
                                        <span class="invalid-feedback passengers_feedback d-block text-center" role="alert"></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="passengers">Suitcases </label>
                                        <input type="number" id="suitcase" name="suitcase" class="form-control" placeholder="Suitcases" value="{{ $ride->suitcase ?? old('suitcase') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="info">Info</label>
                                        <textarea id="info" class="form-control" placeholder="Info" name="info">{{$ride->info ?? old('info')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Baby seat</label>
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            <input class="custom-control-input" id="customSeat" type="checkbox" value="1" name="baby_seat" {{$ride->baby_seat == 1 ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="customSeat">
                                                <span class="text-muted">Check baby seat</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Shared</label>
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            <input class="custom-control-input" {{$ride->shared == 1 ? 'checked' : '' }} id="customShared" type="checkbox" value="1" name="shared">
                                            <label class="custom-control-label" for="customShared">
                                                <span class="text-muted">Share</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-control-label">Additional Stops</label>
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            <input class="custom-control-input" {{$ride->additional == 1 ? 'checked' : '' }} id="stop_check" type="checkbox" value="1" name="stop_check">
                                            <label class="custom-control-label" for="stop_check">
                                                <span class="text-muted">Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 add_stop_btn">
                                    <label class="form-control-label">Add Stop</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-warning plus_square" @if($ride->stops) data-id="{{$last_index}}" @endif><i class="fa fa-plus-square"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" name="additionals" id="additionals" value="{{$ride->stops}}">
                                <div class="col-lg-12 additional_stops">
                                    @if($ride->stops)
                                    @forelse(json_decode($ride->stops) as $k => $stop)
                                        <div class="additional_stop_{{$stop->key}}">
                                            <div class="form-group stop_address_box mt-2 col-6">
                                                <label class="form-control-label" for="pick_up"></label>
                                                <input type="text" data-id="{{$stop->key}}" id="stopAddressSearch{{$stop->key}}" name="stop_address[{{$stop->key}}]" class="form-control stopAddressSearch" placeholder="Stop Address" value="{{$stop->address ? $stop->address : ""}}">
                                                <span class="invalid-feedback stop_address_feedback{{$stop->key}} d-block text-center" role="alert"></span>
                                            </div>
                                            <div class="form-group stop_time_box col-4">
                                                <label class="form-control-label" for="stop_time"> </label>
                                                <select name="stop_time[{{$stop->key}}]" class="form-control additional_info_select" id="additional_select{{$stop->key}}" data-id="{{$stop->key}}">
                                                    <option value="5" {{$stop->min && $stop->min == "5" ? "selected" : ""}}>5 min.</option>
                                                    <option value="10" {{$stop->min && $stop->min == "10" ? "selected" : ""}}>10 min.</option>
                                                    <option value="20" {{$stop->min && $stop->min == "20" ? "selected" : ""}}>20 min.</option>
                                                    <option value="30" {{$stop->min && $stop->min == "30" ? "selected" : ""}}>30 min.</option>
                                                </select>
                                            </div>
                                            <div class="form-group plus_square_box col-2">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger minus_square" data-id="{{$stop->key}}"><i class="fa fa-minus-square"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty

                                    @endforelse
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <hr class="my-4"/>
                        </div>
                        <div class="col-lg-12 text-center">
                            <a href="{{route('dashboard.rides')}}" class="btn btn-default ">Cancel</a>
                            <button type="button" class="btn btn-primary update_ride">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv20gVp7XEbDy4OTN0Sxod2iuEKJjfYeo&libraries=places&callback=initAutocomplete" async defer></script>

    <script type="text/javascript">

        $(document).ready(function(){
            if($("#stop_check").prop("checked") == false){
                $('.additional_stops').css("display", "none");
                $('.add_stop_btn').css("display", "none");
            }
            else if($("#stop_check").prop("checked") == true){
                $('.additional_stops').css("display", "block");
                $('.add_stop_btn').css("display", "block");
            }
        });

        function modalShow(){
            $('#modal_loader').modal('show');
        }

        function modalHide(){
            $('#modal_loader').modal('hide');
        }

        $('.update_ride').on('click', function () {
            var feedback = 0;
            modalShow();
            $('#modal_loader').click();
            $('.update_ride').attr('disabled','disabled');
            $(".date_feedback").html(" ")
            $(".time_feedback").html(" ")
            $(".pick_up_feedback").html(" ")
            $(".destination_feedback").html(" ")
            $(".price_feedback").html(" ")
            $(".passengers_feedback").html(" ")
            $( "#date" ).removeClass( "is-invalid" )
            $( "#time" ).removeClass( "is-invalid" )
            $( "#pick_up" ).removeClass( "is-invalid" )
            $( "#destination" ).removeClass( "is-invalid" )
            $( "#price" ).removeClass( "is-invalid" )
            $( "#passengers" ).removeClass( "is-invalid" )

            if ($("#stop_check").prop("checked")) {
                jQuery(".additional_stops .stop_address_box").each(function() {
                    var input = jQuery(this).find(".stopAddressSearch");
                    input.removeClass("is-invalid")
                    jQuery(this).find(".stop_address_feedback").html(" ")
                    if(!input.val()){
                        input.addClass( "is-invalid")
                        var input_i = parseInt(input.data("id"));
                        $(".stop_address_feedback"+input_i).html('<strong>The stop address can\'t be empty.</strong>')
                        feedback = 1
                    }
                });
            }

            var url = '/dashboard/ride-update/{{$ride->id}}'
            $.ajax({
                url: url,
                type: "post",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: $('#ride_update_form').serialize(),
                success: function (response) {
                    console.log("response", response)
                    $('.update_ride').removeAttr('disabled');
                    setTimeout(function () {
                        modalHide();
                            if (response.error) {
                                if (response.error.date) {
                                    $( "#date" ).addClass( "is-invalid" )
                                    $(".date_feedback").html('<strong>' + response.error.date[0] + '</strong>')
                                }
                                if (response.error.passengers) {
                                    $( "#passengers" ).addClass( "is-invalid" )
                                    $(".passengers_feedback").html('<strong>' + response.error.passengers[0] + '</strong>')
                                }
                                if (response.error.price) {
                                    $( "#price" ).addClass( "is-invalid" )
                                    $(".price_feedback").html('<strong>' + response.error.price[0] + '</strong>')
                                }
                                if (response.error.pick_up) {
                                    $( "#pick_up" ).addClass( "is-invalid" )
                                    $(".pick_up_feedback").html('<strong>' + response.error.pick_up[0] + '</strong>')
                                }
                                if (response.error.destination) {
                                    $( "#destination" ).addClass( "is-invalid" )
                                    $(".destination_feedback").html('<strong>' + response.error.destination[0] + '</strong>')
                                }
                                if (response.error.time) {
                                    $( "#time" ).addClass( "is-invalid" )
                                    $(".time_feedback").html('<strong>' + response.error.time[0] + '</strong>')
                                }
                            }
                            if (response.success  && feedback == 0) {
                                setTimeout(function () {
                                    window.location.href = "/dashboard/rides/";
                                }, 500);
                            }
                    }, 1000);
                },
                error:function (response) {
                    console.log(response)
                }
            })

        });

        var stop_i = $('input[id^="stopAddressSearch"]').data("id");
        console.log($('input[id^="stopAddressSearch"]'))
        $(document).on('input', '.stopAddressSearch', function(){
            stop_i = parseInt($(this).data("id"))
            initAutocomplete()
        })

        function initAutocomplete() {
            var additionals = document.getElementById("additionals").value ? JSON.parse(document.getElementById("additionals").value) : [];
            var input = document.getElementById('pick_up');
            var autocomplete = new google.maps.places.Autocomplete(input, {types: ['geocode']});
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                document.getElementById('pickup_point_lat').value = latitude;
                document.getElementById('pickup_point_lng').value = longitude;
            })

            var input2 = document.getElementById('stopAddressSearch'+stop_i);
            var autocomplete2 = new google.maps.places.Autocomplete(input2, {types: ['geocode']});
            google.maps.event.addListener(autocomplete2, 'place_changed', function () {
                var place2 = autocomplete2.getPlace();
                var latitude2 = place2.geometry.location.lat();
                var longitude2 = place2.geometry.location.lng();
                item = {};
                item ["key"] = stop_i;
                item ["address"] = place2.formatted_address;
                item ["lat"] = latitude2;
                item ["lng"] = longitude2;
                item ["min"] = parseInt($("#additional_select"+stop_i).val());
                Array.prototype.inArray = function(comparer) {
                    for(var i=0; i < this.length; i++) {
                        if(comparer(this[i])) return true;
                    }
                    return false;
                };
                Array.prototype.pushIfNotExist = function(element, comparer) {
                    if (!this.inArray(comparer)) {
                        this.push(element);
                    }
                };
                additionals.pushIfNotExist(item, function(e) {
                    return e.address === item.address && e.lat === item.lat && e.lng === item.lng;
                });
                console.log("additionals", additionals)
                document.getElementById('additionals').value = JSON.stringify(additionals);
            })

        }

        $(document).on('change', '.additional_info_select', function(){
            var additionals = document.getElementById("additionals").value ? JSON.parse(document.getElementById("additionals").value) : [];
            var i = parseInt($(this).data("id"))
            var min = parseInt($(this).val())
            $.each(additionals, function( key, value ) {
                if(value.key == i){
                    value.min = min
                }
            });
            document.getElementById('additionals').value = JSON.stringify(additionals);
        })

        $('#stop_check').change(function(){
            if($(this).prop("checked") == false){
                $('.additional_stops').css("display", "none");
                $('.add_stop_btn').css("display", "none");
            }
            else if($(this).prop("checked") == true){
                $('.additional_stops').css("display", "block");
                $('.add_stop_btn').css("display", "block");
            }
        });


        $('.plus_square').click(function () {
            var i = parseInt($(this).data("id"))
            i++
            $(this).data('id', i);
            $(".additional_stops").append('<div class="additional_stop_'+i+'">\n' +
                '                                        <div class="form-group mt-2 stop_address_box col-6">\n' +
                '                                            <label class="form-control-label" for="pick_up"> </label>\n' +
                '                                            <input type="text" data-id="'+i+'" id="stopAddressSearch'+i+'" name="stop_address['+i+']" class="form-control stopAddressSearch" placeholder="Stop Address" value="">\n' +
                '                                            <span class="invalid-feedback stop_address_feedback'+i+' d-block text-center" role="alert"></span>\n' +
                '                                        </div>\n' +
                '                                        <div class="form-group stop_time_box col-4">\n' +
                '                                            <label class="form-control-label" for="stop_time"> </label>\n' +
                '                                            <select name="stop_time['+i+']" class="form-control additional_info_select" id="additional_select'+i+'" data-id="'+i+'">\n' +
                '                                                <option value="5" selected>5 min.</option>\n' +
                '                                                <option value="10">10 min.</option>\n' +
                '                                                <option value="20">20 min.</option>\n' +
                '                                                <option value="30">30 min.</option>\n' +
                '                                            </select>\n' +
                '                                        </div>\n' +
                '                                        <div class="form-group plus_square_box col-2">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <button type="button" class="btn btn-danger minus_square" data-id="'+i+'"><i class="fa fa-minus-square"></i></button>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>')
        });

        $(document).on('click', '.minus_square', function(){
            var additionals = document.getElementById("additionals").value ? JSON.parse(document.getElementById("additionals").value) : [];
            var new_additionals = [];
            var id = parseInt($(this).data("id"));
            $.each(additionals, function( key, value ) {
                if(value.key != id){
                    new_additionals.push(value)
                }
            });
            document.getElementById('additionals').value = JSON.stringify(new_additionals);
            $(".additional_stop_"+id).remove()
        })

        $(function () {
            $('#datetimepicker4').datetimepicker({
                format: 'L',
                format: 'DD-MM-YYYY',
                ignoreReadonly:true,
                allowInputToggle:true
            });

            $("#datetimepicker4").on("change.datetimepicker", function (e) {
                $('#datetimepicker4').datetimepicker('minDate', new Date());
            });

            $('#datetimepicker3').datetimepicker({
                format: 'LT',
                ignoreReadonly:true,
                allowInputToggle:true
            });
        });

    </script>
@endsection
