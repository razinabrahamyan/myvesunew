@extends('app.layouts.app')
@section('title')
    <h5>AVAILABLE RIDES</h5>
@endsection
@section('content')

        <section id="tabs">
            <div class="container">
                <div class="container-fluid pt-2 pb-2">
                    <div class="row">
                        <div class="col-xs-12 col-12">
                            <nav >
                                <div class="nav nav-tabs nav-fill flex-nowrap" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active ride_category px-0" data-category="own_rides" href="#">My Rides</a>
                                    <a class="nav-item nav-link ride_category px-0" data-category="open_rides" href="#">Open Rides</a>
                                    <a class="nav-item nav-link ride_category px-0" data-category="joined_rides" href="#">Joined Rides</a>
                                </div>
                            </nav>
                            <div class="tab-content py-3 px-3 px-sm-0" >
                                <div class="tab-pane  active" id="rides_desc">
                                    @forelse($rides as $ride)
                                        <a href="{{route("app.ride",$ride->id)}}" class="rides_page_link">
                                            <div class="row my-1 pl-1 justify-content-around ride_item">
                                                <div class="col-5 pr-0">
                                                    <img src="/uploads/rides/{{$ride->image}}" alt="" class="img-fluid">
                                                </div>
                                                <div class="col-6 rides_info">
                                                    <p class="rides_info_seats"><span>{{$ride->count}}</span> Seats</p>
                                                    <p class="rides_info_date">{{Carbon\Carbon::parse($ride->date)->format("D d M")}}</p>
                                                    <p class="rides_info_driver">
                                                        <span>{{$ride->user->first_name}}</span>
                                                        <span>{{$ride->user->last_name}} </span>
                                                    </p>
                                                    @if($ride->driver_id && $ride->driver && $ride->driver->driver && $ride->driver->driver->cars && $ride->driver->driver->cars->first())

                                                        <p class="rides_info_car">{{$ride->driver->driver->cars->first()->make}} {{$ride->driver->driver->cars->first()->model}} • {{$ride->driver->driver->cars->first()->vehicle_registration_number}} </p>
                                                    @endif
                                                    <p class="rides_info_time">~ 4 minutes</p>
                                                    <p class="rides_info_price">€ {{$ride->price}}</p>
                                                </div>
                                            </div>
                                        </a>
                                        @if(!$loop->last)
                                            <hr class="ride_bottom">
                                        @endif
                                    @empty
                                        <div class="col-12 text-center">
                                            <div class="alert">
                                                Available rides not found!
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                </div>
        </section>


        <script>
            $(document).ready(function () {
                $('.ride_category').click(function () {
                    $('#rides_desc').empty();
                    $('#rides_desc')
                        .append('<div id="modal_loader" >\n' +
                        '                                            <img width="40" height="40" src="/assets/img/brand/loader.gif" style="display: block;margin: 0 auto">\n' +
                        '                                    </div>');
                    $('.ride_category').removeClass('active');
                    $(this).addClass('active');
                    let category = $(this).data('category');
                    let week = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    let month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'];
                    $.ajax({
                        url: '/app/rides/'+ category,
                        type: "get",
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            let rides = response.rides;
                            $('#rides_desc').empty();
                            if(rides.length){
                                rides.map(function (ride,index) {
                                    let date = new Date(ride.date);
                                    let finalDate = week[date.getDay()] + ' ' + date.getDate() + ' ' + month[date.getMonth()];
                                    let driver_info = '';
                                    if(ride.driver && ride.driver.driver && ride.driver.driver.cars && ride.driver.driver.cars[0]){
                                        let car = ride.driver.driver.cars[0];
                                        driver_info = '<p class="rides_info_car">'+ car.make +' ' + car.model + ' • '+ car.vehicle_registration_number +'</p>'
                                    }
                                    $('#rides_desc').append('<a href="/app/ride/'+ ride.id +'" class="rides_page_link">\n' +
                                        '                                            <div class="row my-1 pl-1 justify-content-around ride_item">\n' +
                                        '                                                <div class="col-5 pr-0">\n' +
                                        '                                                    <img src="/uploads/rides/'+ ride.image +'" alt="" class="img-fluid">\n' +
                                        '                                                </div>\n' +
                                        '                                                <div class="col-6 rides_info">\n' +
                                        '                                                    <p class="rides_info_seats"><span>'+ ride.count +'</span> Seats</p>\n' +
                                        '                                                    <p class="rides_info_date">'+ finalDate +'</p>\n' +
                                        '                                                    <p class="rides_info_driver">\n' +
                                        '                                                        <span>'+ ride.user.first_name +'</span>\n' +
                                        '                                                        <span>'+ ride.user.last_name +' </span>\n' +
                                        '                                                    </p>\n' + driver_info +
                                        '                                                    <p class="rides_info_time">~ 4 minutes</p>\n' +
                                        '                                                    <p class="rides_info_price">€ '+ ride.price +'</p>\n' +
                                        '                                                </div>\n' +
                                        '                                            </div>\n' +
                                        '                                        </a>');
                                    if(index !== rides.length -1){
                                        $('#rides_desc').append('<hr class="ride_bottom">')
                                    }

                                })
                            }else{
                                $('#rides_desc').append('<div class="col-12 text-center">\n' +
                                    '                                            <div class="alert">\n' +
                                    '                                                Available rides not found!\n' +
                                    '                                            </div>\n' +
                                    '                                        </div>')
                            }




                        }
                    })
                })
            })
        </script>

@endsection


