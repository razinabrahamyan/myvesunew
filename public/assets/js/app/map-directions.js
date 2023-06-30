function initMap() {
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
            if(map.getZoom()<10){
                map.setZoom(10);
            }


        }
    })

}
