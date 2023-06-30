@extends('app.layouts.app')
@section('title')
    <h5>RIDE</h5>
@endsection
@section('content')
    @if(auth()->user()->hasRole('driver'))
        <input type="hidden" value="1" id="is_driver">
    @else
        <input type="hidden" value="0" id="is_driver">
    @endif
    <div class="container ride_info">
        <div class="container-fluid pt-3 pb-3">
            <div class="row pb-2">
                <div class="col-5 pr-0 ride_info_desc">
                    <p><span class="orange_text">€ {{$ride->price}}</span> TRIP COST</p>
                    <p><span class="bold_text" id="distance"></span> km </p>
                    <p>REACHING DESTINATION IN:</p>
                    <p><span class="bold_text" id="hours"></span> hours <span class="bold_text" id="minutes"></span>
                        minutes (+<span id="stops"></span> )</p>
                </div>
                <div class="col-7 ">
                    <div class="row">
                        <div class="col-7 driver_info_desc">
                            @if($driver)
                                @foreach($ride->driver->driver->cars as $car)
                                    <p class="ride_driver_name">{{$driver->first_name}} {{$driver->last_name}}</p>
                                    <p>{{$driver->driver()->first()->cars()->first()->make}} {{$driver->driver()->first()->cars()->first()->model}}</p>
                                    <p><span
                                            class="orange_text">{{$driver->driver()->first()->cars()->first()->type}}</span>
                                        • {{$driver->driver()->first()->cars()->first()->color}}</p>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-5 pl-0 ">
                            <img class="img-fluid rounded" src="/uploads/rides/{{$ride->image}}" alt="">
                        </div>
                    </div>
                    <div class="text-right"><span class="orange_text ride_timer" id="ride_timer">00:00:00</span></div>
                </div>
            </div>
            @if($ride->stops)
                <div class="container-fluid pt-3 pb-3">
                    <div class="row pb-2">
                        <div class="ride_info_desc">
                            <p><span class="bold_text">Additional Stops</span></p>
                            @foreach(json_decode($ride->stops) as $stop)
                                <p><span class="orange_text">{{$stop->address}} - {{$stop->min}} .min</span></p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div id="map" style="width: 100%;height: 400px"></div>
            <p id="my_p"></p>
            <div class="accordion" id="accordion">
                @if($join_rides->passengers()->get())
                    @foreach($join_rides->passengers()->get() as $passenger)
                        <div class="card accordion_card passenger_exists">
                            <div class="card-header" id="heading{{$passenger->id}}">
                                <img class="passenger_avatar" alt="" src="/uploads/avatar/{{$passenger->avatar}}">
                                <span
                                    class="passenger_information">{{$passenger->first_name}} {{$passenger->last_name}}</span>
                                @if(auth()->user()->hasRole('driver'))
                                    <button class="btn myvesu_accordion_btn float-right" type="button"
                                            data-toggle="collapse" data-target="#collapse{{$passenger->id}}"
                                            aria-expanded="true" aria-controls="collapse{{$passenger->id}}">
                                        <i class="fa fa-arrow-circle-down"></i>
                                    </button>
                                    @if($passenger->pivot->status == "wait")
                                        <button @if($ride->status === 'active') disabled
                                                @endif class="btn passenger_status_wait float-right passenger_status_btn"
                                                type="button" data-type="piked_up" data-id="{{$ride->id}}"
                                                data-user="{{$passenger->id}}">Pick
                                        </button>
                                    @elseif($passenger->pivot->status == "piked_up")
                                        <button class="btn passenger_status_piked_up float-right passenger_status_btn"
                                                data-type="ended" data-id="{{$ride->id}}" data-user="{{$passenger->id}}"
                                                type="button">End
                                        </button>
                                    @elseif($passenger->pivot->status == "ended")
                                        <button class="btn passenger_status_ended float-right " type="button">Ended
                                        </button>
                                    @else
                                        <button class="btn passenger_status_paid float-right " type="button">Paid
                                        </button>
                                    @endif
                                @endif
                            </div>
                            @if(auth()->user()->hasRole('driver'))
                                <div id="collapse{{$passenger->id}}" class="collapse hide"
                                     aria-labelledby="heading{{$passenger->id}}" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <a href="tel:{{$passenger->phone}}" class="passenger_call_btn"><i
                                                        class="fa fa-phone mr-1"></i>CALL</a>
                                            </div>
                                            <div class="col-6 text-center">
                                                <a href="{{route('app.chat',$passenger->id)}}"
                                                   class="passenger_call_btn">TEXT <i
                                                        class="fa fa-comment-dots"></i></a>
                                            </div>n
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div id="buttons_place">
        @if($ride->status === 'active' && auth()->user()->hasRole('driver'))
            <button id="start_button" class="start_the_ride_button animate__animated animate__bounceInRight"
                    onclick="startTheRide({{$ride->id}})">Start
            </button>
        @endif
    </div>

    <input type="hidden" id="ride" value="{{$ride}}">
    <input type="hidden" id="ride_id" value="{{$ride->id}}">
    <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv20gVp7XEbDy4OTN0Sxod2iuEKJjfYeo&callback=initMap&sensor=true"></script>
    <script>
        $('.collapse').on('shown.bs.collapse', function () {
            $(this).parent().find(".fa-arrow-circle-down").removeClass("fa-arrow-circle-down").addClass("fa-arrow-circle-up");
        }).on('hidden.bs.collapse', function () {
            $(this).parent().find(".fa-arrow-circle-up").removeClass("fa-arrow-circle-up").addClass("fa-arrow-circle-down");
        });
        function makeTimer(time){
            let timerPlace =  $('#ride_timer');
            setInterval(function () {
                timerPlace.text(makeTime(++time));
            }, 1000);
        }
        realise($('#start_button'));
        let ride = $('#ride').val();
        ride = JSON.parse(ride);
        if(ride.status === 'is_on'){
            let updated_time = new Date(ride.updated_at);
            updated_time.setHours(updated_time.getHours());
            let current_time = new Date($.now());
            let ride_timer = Math.floor((current_time - updated_time)/1000);
            makeTimer(ride_timer);
        }
        if (!$('.passenger_status_btn').length && ride.status === 'is_on' && $('#is_driver').val() === '1') {
            $('#buttons_place').append('<button id="end_button" class="start_the_ride_button animate__animated animate__bounceInRight" onclick="endTheRide()">END</button>');
            realise($('#end_button'));
        }
        $('.accordion_card').on('click', '.passenger_status_btn', function () {
            var button = $(this);
            $.ajax({
                url: '{{route('app.pike.passenger')}}',
                type: "post",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {type: $(this).data("type"), ride_id: $(this).data("id"), user_id: $(this).data("user")},
                success: function (response) {
                    if (response.join_ride && response.ride) {
                        if (response.ride.status === "piked_up") {
                            button.after('<button class="btn passenger_status_piked_up float-right passenger_status_btn " data-type="ended" data-id="' + response.ride.ride_id + '" data-user="' + response.ride.user_id + '" type="button">End</button>')
                            button.remove();
                        } else if (response.ride.status === "ended") {
                            button.after('<button  class="btn passenger_status_ended float-right " data-type="ended" data-id="' + response.ride.ride_id + '" data-user="' + response.ride.user_id + '" type="button">Ended</button>')
                            button.remove();
                        }
                        let active_buttons = $('.passenger_status_btn');
                        if (!active_buttons.length) {
                            $('#buttons_place').append('<button id="end_button" class="start_the_ride_button animate__animated animate__bounceInRight" onclick="endTheRide()">END</button>');
                            realise($('#end_button'));
                            console.log(123)
                            alert(123)
                        }
                    }
                }
            })
        });

        function endTheRide() {
            $.ajax({
                url: '{{route('app.end.ride')}}',
                type: "post",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {ride_id: ride.id},
                success: function (response) {
                    if (response.success === 'success') {
                        $('#end_button').removeClass('animate__bounceInRight');
                        $('#end_button').addClass('animate__fadeOutLeftBig');
                        setTimeout(function () {
                            window.location.href = "/app/own-rides";
                        }, 1000);
                    }
                }

            })
        }

        function makeTime(time) {
            let hours = Math.floor(time / 3600);
            time %= 3600;
            let hoursText = hours < 10 ? '0' + hours : hours ;
            let minutes = Math.floor(time / 60);
            time %= 60;
            let minutesText = minutes < 10 ? '0' + minutes : minutes;
            let secondsText = time < 10 ? '0' + time : time;
            return hoursText + ':' + minutesText + ':' + secondsText;
        }

        function startTheRide() {
            $.ajax({
                url: '{{route('app.start.ride')}}',
                type: "post",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {ride_id: ride.id},
                success: function (response) {
                    if (response.success === 'success') {
                        $('#start_button').removeClass('animate__bounceInRight');
                        $('#start_button').addClass('animate__zoomOutRight');
                        $('.passenger_status_btn').prop('disabled', false);
                        makeTimer(0);
                    }
                    let active_buttons = $('.passenger_status_btn');
                    if (!active_buttons.length) {
                        $('#buttons_place').append('<button id="end_button" class="start_the_ride_button animate__animated animate__bounceInRight" onclick="endTheRide()">END</button>');
                        realise($('#end_button'));
                    }

                }

            })
        }
        function realise(element){
            setTimeout(function () {
                let is_down = false;
                let div = element;
                let divWidth = div.width();
                let divHeight = div.height();
                let body = $('body');
                let startPositionX = 0;
                let startPositionY = 0;
                let divPositionX = parseInt(div.css('right'));
                let divPositionY = parseInt(div.css('bottom'));
                let currentPositionX = 0;
                let currentPositionY = 0;
                let screenWidth = $(window).width()-divWidth -90;
                let screenHeight = $(window).height()-divHeight -350;

                div.on('touchstart',function (e) {
                    is_down = true;
                    $('body').css('overflow-y','hidden')
                    startPositionX = e.changedTouches[0].pageX;
                    startPositionY = e.changedTouches[0].pageY;

                })
                body.on('touchmove',function (e) {
                    if (is_down){
                        currentPositionX =divPositionX - e.changedTouches[0].pageX + startPositionX ;
                        currentPositionY =divPositionY - e.changedTouches[0].pageY + startPositionY;
                        if(currentPositionX >= screenWidth){
                            currentPositionX = screenWidth;
                        }
                        if(currentPositionY >= screenHeight){
                            currentPositionY = screenHeight;
                        }
                        if(currentPositionX <= 10){
                            currentPositionX = 10;
                        }
                        if(currentPositionY <= 70){
                            currentPositionY = 70;
                        }
                        div.css('right',currentPositionX);
                        div.css('bottom',currentPositionY);

                    }
                })

                body.on('touchend',function (e) {
                    $('body').css('overflow-y','scroll')
                    is_down = false;
                    divPositionX = currentPositionX;
                    divPositionY = currentPositionY;
                })
            },1000)

        }


    </script>
    <script src="{{asset('assets/js/app/map-directions.js')}}"></script>
@endsection
