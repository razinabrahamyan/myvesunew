@extends('app.layouts.app')
@section('title')
    <h5>ON THE WAY</h5>
@endsection
@section('content')
    <div class="container ride_info">
        <div class="container-fluid pt-3 pb-3">
            <div class="row pb-2">
                <div class="col-6 driver_info_on_way">
                    <h2 class="arriving">ARRIVING</h2>
                    <span class="arriving_time">03</span>
                    <span class="arriving_minutes">minutes</span>
                </div>
                <div class="col-6">
                    <img class="driver_vehicle_image" src="/uploads/vehicle/{{$driver->driver()->first()->cars()->first()->vehicle_photo}}" alt="">
                </div>
                <div class="col-12 driver_info_on_way mt-2">
                    <h3 class="text-right">{{$driver->first_name}} {{$driver->last_name}}</h3>
                    <h5 class="text-right"><strong>{{$driver->driver()->first()->cars()->first()->color}}</strong> {{$driver->driver()->first()->cars()->first()->make}} {{$driver->driver()->first()->cars()->first()->model}} • {{$driver->driver()->first()->cars()->first()->vehicle_registration_number}}</h5>
                </div>
            </div>
            <div id="on_way_ride_map" style="width: 100%;height: 400px"></div>
            <div class="row mt-3">
                @if($join_rides && $join_rides->status == "ended")
                    <div class="col-12 text-center">
                        <a href="{{route('app.checkout', ["user" => auth()->user(), "ride" => $ride])}}" class="myvesu_call_btn"><i class="fa fa-check mr-1"></i>CHECKOUT</a>
                    </div>
                @else
                    <div class="col-6 text-center">
                        <a href="tel:{{$driver->phone}}" class="myvesu_call_btn"><i class="fa fa-phone mr-1"></i>CALL</a>
                    </div>
                    <div class="col-6 text-center">
                        <a href="{{route('app.chat',$driver->id)}}" class="myvesu_call_btn">TEXT <i class="fa fa-comment-dots"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv20gVp7XEbDy4OTN0Sxod2iuEKJjfYeo&callback=initMap"></script>
    <script>
        var stops = jQuery.parseJSON('<?php echo $ride->stops; ?>');
        var driver = '{{$driver}}';
        var car;
        function getdriverInfo() {
            $.ajax({
                url: '{{route('app.driver.info')}}',
                type: "POST",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{id: '{{$driver->id}}'},
                success: function (response) {
                    if(response) {
                        driver = response.driver
                        car = response.car
                        initMap()
                    }
                }
            })
        }
        getdriverInfo();
        function initMap() {
            var directionsRenderer = new google.maps.DirectionsRenderer();
            var myLatlng = new google.maps.LatLng('{{$ride->pick_up_lat}}','{{$ride->pick_up_lng}}');
            var mapOptions = {
                zoom:13,
                center: myLatlng
            };
            var map = new google.maps.Map(document.getElementById('on_way_ride_map'), mapOptions);
            directionsRenderer.setMap(map);
            var marker = new google.maps.Marker({
                position: myLatlng,
                title:"{{$ride->pick_up}}"
            });
            (function (marker) {
                google.maps.event.addListener(marker, "click", function (e) {
                    //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
                    infoWindow.setContent('<div class="info-window-content"><p>'+"{{$ride->pick_up}}"+'</p></div>');
                    infoWindow.open(map, marker);
                });
            })(marker);
            var infoWindow = new google.maps.InfoWindow();
            marker.setMap(map);
            setMarkers(map);
            setDriverMarker(map);
        }

        function setDriverMarker(map) {
            var icon = {
                url: '/assets/img/brand/car.png', // url
                scaledSize: new google.maps.Size(50, 30), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(driver.lat, driver.lng),
                icon: icon,
                map: map,
            });
            (function (marker) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent('<div class="info-window-content"><p>'+driver.first_name+' '+driver.last_name+'</p><p>'+car.color+' '+car.make+' '+car.model+'</p></div>');
                    infoWindow.open(map, marker);
                });
            })(marker);
            var infoWindow = new google.maps.InfoWindow();
        }

        function setMarkers(map) {
            $.each(stops, function( index, value ) {
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(value.lat, value.lng),
                    map: map,
                });
                (function (marker, value) {
                    google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent('<div class="info-window-content"><p>'+value.address+'</p></div>');
                        infoWindow.open(map, marker);
                    });
                })(marker, value);
            });
            var infoWindow = new google.maps.InfoWindow();
        }
        setInterval(function () {
            getdriverInfo();
        }, 20000);
    </script>

@endsection
