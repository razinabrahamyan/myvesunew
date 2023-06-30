let id = 0;
let drivers = JSON.parse($('#drivers').val());
let markers = [];
$('#select-driver').on('change', function () {
    id = this.value;
    getOnlineDrivers();
});

function getOnlineDrivers() {
    $.ajax({
        url: 'online-drivers',
        type: "POST",
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{id: id},
        success: function (response) {
            if(response && response['drivers']) {
                console.log(response['drivers'])
                drivers = response['drivers'];
                clearMarkers();
                initMap()
            }
        },
        error:function (response) {
            console.log('error',response)
        }
    })
}
function initMap() {
    let myLatlng = new google.maps.LatLng(40.211905, 44.517430);
    let mapOptions = {
        zoom:13,
        center: myLatlng
    };
    let map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    let icon = {
        url: '/assets/img/brand/car-marker.png', // url
        scaledSize: new google.maps.Size(60, 30), // scaled size
        origin: new google.maps.Point(0,0), // origin
        anchor: new google.maps.Point(0, 0) // anchor
    };
    $.each(drivers, function( index, value ) {
        let marker = new google.maps.Marker({
            position: new google.maps.LatLng(value.lat, value.lng),
            icon: icon,
            map: map,
        });
        markers.push(marker);
        //Attach click event to the marker.
        (function (marker, value) {
            google.maps.event.addListener(marker, "click", function (e) {
                //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
                infoWindow.setContent('<div class="info-window-content"><h2>'+value.username+'</h2>' +
                    '<p>'+value.type+' '+value.year+' '+value.color+' '+value.make+' '+value.model+'</p>' +
                    '</div>');
                infoWindow.open(map, marker);
            });
        })(marker, 0);
    });
    let infoWindow = new google.maps.InfoWindow();
}
function clearMarkers(){
    for (let i = 0;i < markers.length; i++){
        markers[i].setMap(null);
    }
    markers = [];
}
setInterval(function () {
    getOnlineDrivers();
}, 20000);
