@extends('app.layouts.app')

@section('title')
    <h5>BOOK YOUR RIDE</h5>
@endsection

@section('content')
    <div class="modal fade bd-example-modal-lg"  id="modal_loader">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <img width="60" height="60" src="{{asset("/assets/img/brand/loader.gif")}}">
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg"  id="modal_check">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <i class="fas fa-check modal_check_icon"></i>
            </div>
        </div>
    </div>

    <div class="col-12 booking_ride">
        <form id="book_ride">
            @csrf
            <div class="first_part_of_booking">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-4 date" id="date_of_ride" data-target-input="nearest">
                            <input class="form-control myvesu_input_group datetimepicker-input" data-target="#date_of_ride" value="{{old('date')}}" placeholder="Date Of Ride" type="text" name="date" readonly>
                            <div class="isnput-group-prepend" data-target="#date_of_ride" data-toggle="datetimepicker">
                                <span class="input_group_text"><i class="fa fa-calendar-alt"></i></span>
                            </div>
                            <span class="invalid-feedback date_feedback d-block text-center" role="alert"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-4">
                            <input type="text" class="form-control myvesu_input_group" value="{{old("pickup_point")}}" id="searchMapInput" name="pickup_point" placeholder="Pick Up Point">
                            <input type="hidden" value="" id="pickup_point_lat" name="pickup_point_lat">
                            <input type="hidden" value="" id="pickup_point_lng" name="pickup_point_lng">
                            <div class="input-group-prepend">
                                <span class="input_group_text"><i class="fa fa-location-arrow"></i></span>
                            </div>
                            <span class="invalid-feedback pickup_point_feedback d-block text-center" role="alert"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-4">
                            <select class="custom-select myvesu_select" name="destination">
                                @foreach($destinations as $destination)
                                    <option value="{{$destination->id}}" {{old('destination') == $destination->id ? 'selected':''}}>{{$destination->address}}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="invalid-feedback destination_feedback d-block text-center" role="alert"></span>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center myvesu_radio mb-3">
                        <label class="radio-inline mr-2">additional stops ?</label>
                        <label class="radio-inline mr-1 myvesu_radio_label">
                            <input type="radio" name="stop_check" class="additional_stops" value="1" {{old('stop_check') === '1'? 'checked':''}}>
                            Yes
                            <span class="checkmark"></span>
                        </label>
                        <label class="radio-inline myvesu_radio_label">
                            <input type="radio" class="additional_stops" name="stop_check" value="0" checked>
                            No
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="row stop_address_list">
                    <div class="col-6 stop_0">
                        <div class="input-group stop_address_input mb-4">
                            <input type="text" class="form-control myvesu_input additional_info stopAddressSearch" data-id="0" value="{{old("stop_address[0]")}}" name="stop_address[0]" id="stopAddressSearch0"  placeholder="Stop Address">
                            <span class="invalid-feedback stop_feedback stop_address_feedback0 d-block text-center" role="alert"></span>
                        </div>
                        <input type="hidden" name="additionals" id="additionals" value="">
                    </div>
                    <div class="col-4 stop_0">
                        <div class="input-group mb-4">
                            <select class="custom-select myvesu_select additional_info additional_info_select" id="additional_select0" data-id="0" name="stop_time[0]">
                                <option value="5"  {{old('stop_time[0]') == '5'? 'selected':''}} selected>5 min.</option>
                                <option value="10" {{old('stop_time[0]') == '10'? 'selected':''}}>10 min.</option>
                                <option value="20" {{old('stop_time[0]') == '20'? 'selected':''}}>20 min.</option>
                                <option value="30" {{old('stop_time[0]') == '30'? 'selected':''}}>30 min.</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 stop_0">
                        <div class="input-group mb-4">
                            <button type="button" class="btn btn-default myvesu_plus_btn" data-id="0"><i class="fa fa-plus-square"></i></button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-4 date" id="pick_up_time" data-target-input="nearest">
                            <input type="text" class="form-control myvesu_input_group datetimepicker-input" data-target="#pick_up_time" placeholder="Pick Up Time" value="{{old("pick_up_time")}}" name="pick_up_time" readonly>
                            <div class="input-group-prepend" data-target="#pick_up_time" data-toggle="datetimepicker">
                                <span class="input_group_text"><i class="fa fa-clock"></i></span>
                            </div>
                            <span class="invalid-feedback pick_up_time_feedback d-block text-center" role="alert"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-4">
                            <input type="number" min="1" max="9999" class="form-control myvesu_input_group" id="price" value="{{old("price")}}" placeholder="Price" name="price">
                            <div class="input-group-prepend">
                                <span class="input_group_text"><i class="fa fa-dollar-sign"></i></span>
                            </div>
                            <span class="invalid-feedback price_feedback d-block text-center" role="alert"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center myvesu_radio">
                        <label class="radio-inline mr-2">share the ride ?</label>
                        <label class="radio-inline mr-1 myvesu_radio_label">
                            <input type="radio" name="share_check" value="1" class="share_the_ride" checked>
                            Yes
                            <span class="checkmark"></span>
                        </label>
                        <label class="radio-inline myvesu_radio_label">
                            <input type="radio" name="share_check" value="0" class="share_the_ride" {{old('share_check') === '0'? 'checked':''}}>
                            No
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-default myvesu_btn next_booking">Next</button>
                    </div>
                </div>
            </div>

            <div class="second_part_of_booking">
                <div class="row">
                    <div class="col-7">
                        <div class="input-group mb-2">
                            <label class="myvesu_select_label"><i class="fa fa-users mr-2"></i><span>number of passengers</span></label>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="input-group mb-4">
                            <select class="custom-select myvesu_select" name="passengers">
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="{{$i}}"  {{old('passengers') == $i? 'selected':''}}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7">
                        <div class="input-group mb-2">
                            <label class="myvesu_select_label"><i class="fa fa-baby mr-2"></i><span>baby booster seat?</span></label>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="input-group mb-2 baby_booster_seat">
                            <label class="radio-inline myvesu_radio_label">
                                <input type="radio" name="baby_check" value="1" class="baby_check" {{old('baby_check') === '1'? 'checked':''}}>
                                Yes
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-inline myvesu_radio_label baby_booster">
                                <input type="radio" name="baby_check" value="0" class="baby_check" checked>
                                No
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7">
                        <div class="input-group mb-2">
                            <label class="myvesu_select_label"><i class="fa fa-suitcase-rolling mr-2"></i><span>number of suitcases</span></label>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="input-group mb-2">
                            <select class="custom-select myvesu_select" name="suitcase">
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="{{$i}}"  {{old('suitcase') == $i? 'selected':''}}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-12">
                            <label class="checkbox">
                                <input type="checkbox" name="additional_information" id="additional_information">
                                <span class="additional_information_label">additional information </span>
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <textarea class="myvesu_textarea" name="additional_info" id="specify" placeholder="Please Specify">{{old("please_specify")}}</textarea>
                    </div>
                </div>

                @if(auth()->user()->hasRole('passenger'))
                    <hr style="border: 1px solid">
                    <div class="row">
                        <div class="col-7">
                            <div class="input-group mb-2">
                                <label class="myvesu_select_label"><i class="fa fa-comment-dollar mr-2"></i><span>PAYMENT DETAILS</span></label>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="input-group mb-2 baby_booster_seat">
                                <label class="radio-inline myvesu_radio_label">
                                    <input type="radio" name="payment" value="cash" class="payment" checked>
                                    Cash
                                    <span class="checkmark"></span>
                                </label>
                                <label class="radio-inline myvesu_radio_label">
                                    <input type="radio" name="payment" value="card" class="payment" {{old('baby_check') === '1'? 'checked':''}}>
                                    Card
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-2">
                                <select class="custom-select myvesu_select company" name="invoice">
                                    <option selected value="">Invoice Company</option>
                                    <option value="ikea " {{old('company') === 'ikea'? 'selected':''}}>IKEA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group row mt-3">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-default myvesu_btn next_booking">BOOK NOW</button>
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <div class="col-6">
                        <button type="button" class="btn myvesu_btn_default go_back_edit"><< GO BACK & EDIT</button>
                    </div>

                    <div class="col-6 text-right pt-2">
                        <a class="close_booking" href="{{route("app.own.rides")}}">CANCEL <i class="fa fa-window-close"></i></a>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv20gVp7XEbDy4OTN0Sxod2iuEKJjfYeo&libraries=places&callback=initAutocomplete" async defer></script>

    <script type="text/javascript">
                var stop_i = 0;
                $(document).on('input', '.stopAddressSearch', function(){
                    stop_i = parseInt($(this).data("id"))
                    initAutocomplete()
                })

                $(document).on('change', '.additional_info_select', function(){
                    var additionals = $("#additionals").val() ? JSON.parse($("#additionals").val()) : [];
                    var i = parseInt($(this).data("id"))
                    var min = parseInt($(this).val())
                    $.each(additionals, function( key, value ) {
                        if(value.key == i){
                            value.min = min
                        }
                    });
                    document.getElementById('additionals').value = JSON.stringify(additionals);
                })


                function initAutocomplete() {
                    var additionals = $("#additionals").val() ? JSON.parse($("#additionals").val()) : [];
                    var input = document.getElementById('searchMapInput');
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
                        document.getElementById('additionals').value = JSON.stringify(additionals);
                    })
                }

                $('.go_back_edit').click(function () {
                    $(".second_part").remove();
                    $(".first_part_of_booking").show(400);
                    $(".second_part_of_booking").hide(400)
                });

                function modalShow(){
                    $('#modal_loader').modal('show');
                }

                function modalHide(){
                    $('#modal_loader').modal('hide');
                }


                $('.next_booking').on('click', function () {
                    var feedback = 0;
                    modalShow();
                    $(".date_feedback").html(" ")
                    $(".pickup_point_feedback").html(" ")
                    $(".pick_up_time_feedback").html(" ")
                    $(".price_feedback").html(" ")
                    if ($(".additional_stops").prop("checked")) {
                        jQuery(".stop_address_list .stop_address_input").each(function() {
                            var input = jQuery(this).find(".stopAddressSearch");
                            jQuery(this).find(".stop_feedback").html(" ")
                            if(!input.val()){
                                var input_i = parseInt(input.data("id"));
                                $(".stop_address_feedback"+input_i).html('<strong>The stop address can\'t be empty.</strong>')
                                feedback = 1
                            }
                        });
                    }

                    $.ajax({
                        url: '{{route('app.book.ride')}}',
                        type: "post",
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: $('#book_ride').serialize(),
                        success: function (response) {
                            setTimeout(function () {
                                modalHide();
                                if (response.error) {
                                    if (response.error.date) {
                                        $(".date_feedback").html('<strong>' + response.error.date[0] + '</strong>')
                                    }
                                    if (response.error.pickup_point) {
                                        $(".pickup_point_feedback").html('<strong>' + response.error.pickup_point[0] + '</strong>')
                                    }
                                    if (response.error.pick_up_time) {
                                        $(".pick_up_time_feedback").html('<strong>' + response.error.pick_up_time[0] + '</strong>')
                                    }
                                    if (response.error.price) {
                                        $(".price_feedback").html('<strong>' + response.error.price[0] + '</strong>')
                                    }
                                }
                                if (response.success && feedback == 0) {
                                    $('#book_ride').append('<input type="hidden" class="second_part" name="second_part" value="1">')
                                    $(".first_part_of_booking").hide(400)
                                    $(".second_part_of_booking").show(400)
                                }
                                if (response.ride && response.ride.id && feedback == 0) {
                                    $('#modal_check').modal('show');
                                    setTimeout(function () {
                                        window.location.href = "/app/ride/" + response.ride.id;
                                    }, 1000);
                                }
                            }, 1000);
                        }
                    })

        });

        $(function () {
            $('#date_of_ride').datetimepicker({
                format: 'L',
                format: 'DD-MM-YYYY',
                ignoreReadonly:true,
                allowInputToggle:true
            });

            $("#date_of_ride").on("change.datetimepicker", function (e) {
                $('#date_of_ride').datetimepicker('minDate', new Date());
            });

            $('#pick_up_time').datetimepicker({
                format: 'LT',
                ignoreReadonly:true,
                allowInputToggle:true
            });

            $('.additional_info').prop('disabled', true);
            $('.myvesu_plus_btn').prop("disabled", true);

            $('.additional_stops').change(function () {
                if($(this).val() === '1'){
                    $('.additional_info').prop('disabled',false);
                    $('.myvesu_plus_btn').attr("disabled", false);
                } else {
                    $('.additional_info').prop('disabled',true);
                    $('.myvesu_plus_btn').prop("disabled", true);
                }
            });

            $('#specify').prop('disabled',true);
            $('#specify').css('color','#B1B1B1');
            $('#specify').css('background-color','#F3F3F3')

            $('.myvesu_plus_btn').click(function () {
                var i = parseInt($(this).data("id"))
                i++
                $(this).data('id', i);
                $(".stop_address_list").append('<div class="col-6 stop_'+i+'">' +
                    '                        <div class="input-group stop_address_input mb-4">' +
                    '                            <input type="text" class="form-control myvesu_input additional_info stopAddressSearch" data-id="'+i+'" id="stopAddressSearch'+i+'" value="" name="stop_address['+i+']"  placeholder="Stop Address">' +
                    '                            <span class="invalid-feedback stop_feedback stop_address_feedback'+i+' d-block text-center" role="alert"></span>' +
                    '                        </div>' +
                    '                    </div>' +
                    '                    <div class="col-4 stop_'+i+'">' +
                    '                        <div class="input-group mb-4">' +
                    '                            <select class="custom-select myvesu_select additional_info additional_info_select" id="additional_select'+i+'" data-id="'+i+'" name="stop_time['+i+']">' +
                    '                                <option value="5" selected>5 min.</option>' +
                    '                                <option value="10">10 min.</option>' +
                    '                                <option value="20">20 min.</option>' +
                    '                                <option value="30">30 min.</option>' +
                    '                            </select>' +
                    '                        </div>' +
                    '                    </div>' +
                    '                   <div class="col-2 stop_'+i+'">'+
                    '                       <div class="input-group mb-4">'+
                    '                           <button type="button" class="btn btn-default myvesu_minus_btn" data-id="'+i+'"><i class="fa fa-minus-square"></i></button>'+
                    '                        </div>'+
                     '                   </div>')
            });

            $(document).on('click', '.myvesu_minus_btn', function(){
                var additionals = $("#additionals").val() ? JSON.parse($("#additionals").val()) : [];
                var new_additionals = [];
                var id = parseInt($(this).data("id"));
                $.each(additionals, function( key, value ) {
                    if(value.key != id){
                        new_additionals.push(value)
                    }
                });
                document.getElementById('additionals').value = JSON.stringify(new_additionals);
                $(".stop_"+id).remove()
            })

            $('#additional_information').click(function () {
                if($(this).is(':checked')){
                    $('#specify').prop('disabled',false);
                    $('#specify').css('color','#323232');
                    $('#specify').css('background-color','#EBEBEB')
                }
                else{
                    $('#specify').prop('disabled',true);
                    $('#specify').css('color','#B1B1B1');
                    $('#specify').css('background-color','#F3F3F3')
                }
            });
        });
    </script>
@endsection
