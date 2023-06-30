<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('/assets/img/brand/myvesu_logo.png') }}"  rel="icon" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <script src="{{asset('/assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
    <link href="{{ asset('/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <main>
        <div class="container-fluid payment_success_main">
            <div class="container-fluid mx-auto mt-5 pt-3">
                <img src="{{asset('assets/img/brand/logo.png')}}" class="mx-auto d-block" style="width: 60%">
            </div>
            <div class="container-fluid text-center mt-4 payment_ride_number">
                <p>Thank you using MyVesu</p>
                <p>Ride # <span class="orange_text">252-121X454-SD4</span> • 28 MAY 2020</p>
            </div>
            <div class="container-fluid text-center payment_voucher_div mt-4">
                <p>PAYMENT SUCCESSFUL</p>
                <p>recipient voucher confirming your payment is sent to your accounts registered email address</p>
            </div>
            <div class="container-fluid text-center mt-3">
                <a href="#extension-modal" data-toggle="modal" class="btn btn-default rate_ride_btn"><i class="fa fa-thumbs-up"></i> RATE the RIDE</a>
            </div>
            <div class="container-fluid text-center payment_details mt-3">
                <p>details of your ride are saved in your account`s history.You can view it by clicking the below button or checking history later from your settings.</p>
            </div>
            <div class="container-fluid text-center my-3">
                <button class="btn btn-default myvesu_btn"> view booking details</button>
            </div>
        </div>

    </main>
</div>

<div class="modal fade" id="extension-modal">
    <div class="modal-dialog">
        <div class="modal-content rate_modal_main mt-4">
            <!-- Modal body -->
            <div class="modal-body modal_center ">
                <div class="container-fluid mt-5">
                    <div class="container mx-auto ">
                        <img class="d-block mx-auto" src="{{asset('assets/img/brand/rate_img.png')}}" alt="">
                    </div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="container text-center">
                        <p class="rate_ride">PLEASE RATE YOUR RIDE</p>
                    </div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="container text-center">
                        <p>Your ratings help us to improve our service quality.Customer satisfaction is our prime concern</p>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row justify-content-around px-5 star_rating_div">
                        <div data-value="1" class="rating_item">
                            <i class="fa fa-star"></i>
                        </div>
                        <div data-value="2" class="rating_item">
                            <i class="fa fa-star"></i>
                        </div>
                        <div data-value="3" class="rating_item">
                            <i class="fa fa-star"></i>
                        </div>
                        <div data-value="4" class="rating_item">
                            <i class="fa fa-star"></i>
                        </div>
                        <div data-value="5" class="rating_item">
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </div>

                <form role="form" class="enquiry-form extension-form w-100 p-30" method="POST" action="{{route('app.rate.ride')}}">
                    @csrf
                    <input type="hidden" name="driver_id" value='{{$driver_id}}' id="driver_id">
                    <input type="hidden" name="value" id="rating_value">
                    <div class="container-fluid mt-4 mb-3">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit"  class="btn btn-default d-block mx-auto rate_button">Submit</button>
                            </div>
                            <div class="col-6">
                                <button type="button"data-dismiss="modal"  class="btn btn-default d-block mx-auto rate_button">Cancel</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.rating_item').click(function () {
            let current = $(this).data('value');
            $('.rating_item').removeClass('active_star');
            $('.rating_item').each(function (index,value) {
                if(index+1 <= current){
                    $('.rating_item').eq(index).addClass('active_star');
                }
            });
            $('#rating_value').val(current);
        })
    })
</script>

<script src="{{asset('/assets/js/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/main.js')}}"></script>
<script src="{{asset('/js/popper.min.js')}}"></script>
<script src="{{asset('/js/moment.min.js')}}"></script>
<script src="{{asset('/js/tempusdominus-bootstrap-4.min.js')}}"></script>
{{--<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap" async defer></script>--}}
</body>
</html>
