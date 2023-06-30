@extends('app.layouts.app')
@section('title')
    <h5>AVAILABLE RIDES </h5>
@endsection
@section('content')
    <div class="container ride_info">
        <div class="container-fluid pt-3 pb-3">
            <div class="row pb-2">
                <div class="col-5 pr-0 ride_info_desc">
                    <p><span class="orange_text">€ {{$ride->price}}</span>TRIP COST</p>
                    <p><span class="bold_text" id="distance"></span> km </p>
                    <p>REACHING DESTINATION - {{$ride->destination}}</p>
                    <p>{{$ride->pick_up}}</p>
                    <p><span class="bold_text" id="hours"></span> hours <span class="bold_text" id="minutes"></span> minutes (+<span id="stops"></span> )</p>
                </div>
                <div class="col-7 ">
                    <div class="row">
                        <div class="col-7 driver_info_desc">
                            @if($driver)
                                @foreach($ride->driver->driver->cars as $car)
                                    <p class="ride_driver_name">{{$driver->first_name}} {{$driver->last_name}}</p>
                                    <p>{{$driver->driver()->first()->cars()->first()->make}} {{$driver->driver()->first()->cars()->first()->model}}</p>
                                    <p><span class="orange_text">{{$driver->driver()->first()->cars()->first()->type}}</span> • {{$driver->driver()->first()->cars()->first()->color}}</p>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-5 pl-0 ">
                            <img class="img-fluid rounded" src="/uploads/rides/{{$ride->image}}" alt="">
                        </div>
                    </div>
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
            <div id="map" style="width: 100%;height: 500px"></div>

            <div class="text-center mt-3">
                @if(auth()->user()->hasRole('driver'))
                    @if($ride->driver_id  == auth()->user()->id)
                        <a class="join_button text-center" href="#">Ride is already picked</a>
                    @elseif(!$ride->driver_id || $ride->driver_id  == 0)
                        <a class="join_button text-center"  href="{{route('app.pick.ride',$ride)}}">Pick the ride</a>
                    @else
                        <a class="join_button text-center" href="#">You can't pick the ride</a>
                    @endif

                @elseif(auth()->user()->hasRole('passenger'))
                    @if($ride->allPassengers()->find(auth()->user()->id) && $ride->allPassengers()->find(auth()->user()->id)->pivot)
                        @if($ride->allPassengers()->find(auth()->user()->id)->pivot->approved === "wait")
                            <a class="join_button text-center" href="#">Join request is sent</a>
                        @elseif($ride->allPassengers()->find(auth()->user()->id)->pivot->approved === "1")
                            <a class="join_button text-center" href="#">You have already joined the ride</a>
                        @elseif($ride->allPassengers()->find(auth()->user()->id)->pivot->approved === "0")
                            <a class="join_button text-center" href="#">You can't join the ride</a>
                        @endif
                    @elseif($ride->count !== 0)
                        <a class="join_button text-center" href="{{route('app.join.ride', $ride)}}">Join</a>
                    @else
                        <a class="join_button text-center" href="#">You can't join the ride</a>
                    @endif
                @endif
            </div>
            <div class="row  mt-3">
                <div class="text-center col-6">
                    <a class="join_button text-center" href="{{route('app.driver.ride', $ride)}}">Details</a>
                </div>
                <div class="text-center col-6">
                    <a class="join_button text-center" href="{{route('app.invitation', $ride)}}">Invite</a>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="ride" value="{{$ride}}">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv20gVp7XEbDy4OTN0Sxod2iuEKJjfYeo&callback=initMap&libraries=geometry"></script>
    <script>
        function initMap() {
            function calcDistance(lat1,lng1,lat2,lng2){
                let R = 6366;
                let rlat1 = lat1 * (Math.PI/180);
                let rlat2 = lat2 * (Math.PI/180);
                let difflat = rlat2-rlat1;
                let difflon = (lng2-lng1) * (Math.PI/180);
                let d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)))
                return d;
            }
            let markers = [];
            let directionService = new google.maps.DirectionsService();
            let waypoints=[];
            let ride = document.getElementById('ride').value;
            ride = JSON.parse(ride);
            let stops = JSON.parse(ride.stops);
            let pickup = {lat:parseFloat(ride.pick_up_lat),lng:parseFloat(ride.pick_up_lng)};
            let destination = {lat:parseFloat(ride.destination.lat),lng:parseFloat(ride.destination.lng)};
            let mapOptions = {
                center: pickup,
                initialZoom:false
            };
            let map = new google.maps.Map(document.getElementById('map'), mapOptions);
            let startMarker = new google.maps.Marker({
                position: pickup,
                icon: 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|F3C129',
                map: map,
            });
            function zoom(distance){
                let zooms = [300,140,75,35,20,9,4.5,2.4,1.15];
                let ans = 6;
                if(distance > 300){
                    ans = 6
                }else{
                    for(let i = 0; i< zooms.length; i++){
                        if(distance < zooms[i]){
                            ans++;
                        }
                    }
                }
                return ans;
            }
            if(stops){
                for(let i = 0; i < stops.length; i++){
                    waypoints.push({location:{lat:stops[i].lat,lng:stops[i].lng}})
                    let marker = new google.maps.Marker({
                        position: new google.maps.LatLng(stops[i].lat, stops[i].lng),
                        icon: 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|F3C129',
                        map: map,
                    });
                }
            }
            let endMarker = new google.maps.Marker({
                position: destination,
                icon: 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=B|F3C129',
                map: map,
            });
            let request = {
                origin:pickup,
                destination:destination,
                waypoints:waypoints,
                travelMode:'DRIVING'
            };
            let distance = 0;
            let duration = 0;
            let distanceSpan = document.getElementById('distance');
            let hoursSpan = document.getElementById('hours');
            let minutesSpan = document.getElementById('minutes');
            let stopSpan = document.getElementById('stops');
            let directionsRenderer = new google.maps.DirectionsRenderer({
                polylineOptions: {
                    strokeColor: "#f7941d"
                },
                suppressMarkers: true,
                preserveViewport: true
            });
            directionsRenderer.setMap(map);
            directionService.route(request,function(result, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                    let legs = result.routes[0].legs;
                    for(let i = 0;i < legs.length; i++){
                        distance += legs[i].distance.value
                        duration += legs[i].duration.value
                    }
                    distance/=1000;
                    distance = Math.round(distance * 10)/10;
                    duration = Math.ceil(duration/60);
                    distanceSpan.innerText = distance;
                    hoursSpan.innerText = Math.floor(duration/60);
                    minutesSpan.innerText =duration % 60;
                    stopSpan.innerText = waypoints.length + 'stops';
                    map.fitBounds(result.routes[0].bounds);
                    console.log(result,pickup,destination);
                    let lat1 = pickup.lat;
                    let lng1 = pickup.lng;
                    let lat2 = destination.lat;
                    let lng2 = destination.lng;
                    let dist = calcDistance(lat1,lng1,lat2,lng2)
                    map.setZoom(zoom(dist));
                    console.log(dist,'asdasdasd')


                }
            })

        }

    </script>



@endsection
