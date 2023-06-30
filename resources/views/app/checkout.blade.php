@extends('app.layouts.app')
@section('title')
    <h5>CHECKOUT</h5>
@endsection
@section('content')
    <div class="container checkout_div">
        <div class="row container-fluid mx-0 px-2 mt-4 py-2 checkout_info">
            <div class="col-4 checkout_flex_div mx-0 px-0">
                <div class="checkout_price">
                    <p>{{$ride->price}}€</p>
                </div>
                <div>
                    <p><span>7.7</span> km</p>
                    <p><span>00:18:10</span> minutes</p>
                </div>
            </div>
            <div class="col-8 payment_method_desc">
                <p>PAYMENT METHODS</p>
                <p>You have arrived to your destination and your ride is completed.Please select a payment method from the options listed below in order to complete your checkout</p>
            </div>
        </div>
        <form method="post" action="{{route('app.pay')}}">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <input type="hidden" name="ride_id" value="{{$ride->id}}">
            <input type="hidden" name="price" value="{{$ride->price}}">
            <input type="hidden" name="payment_method" id="payment_method">
            @if($notification_id)
                <input type="hidden" name="notification_id" value="{{$notification_id}}">
            @endif
            <input type="hidden" name="driver_id" value="{{$ride->driver_id}}">
            <div class="container-fluid mt-4 paypal_checkout rounded pb-3" data-value="paypal">
                <div class="pl-3 col-8 pt-3">
                    <p class="heading_p pt-2 mb-1">Paypal</p>
                    <p class="mb-1 mt-0">{{$user->email}}</p>
                </div>
                <div class="col-4 checkmark_div">
                    <i class="fa fa-check"></i>
                </div>
            </div>

            <div class="container-fluid mt-4 paypal_checkout rounded pb-3" data-value="visa">
                <div class="pl-3 col-8 pt-3">
                    <p class="heading_p pt-2 mb-1">Visa</p>
                    <p class="mb-1 mt-0">**** **** **** 2323</p>
                </div>
                <div class="col-4 checkmark_div">
                    <i class="fa fa-check"></i>
                </div>
            </div>

            <div class="container-fluid mt-4 paypal_checkout rounded pb-3" data-value="mastercard">
                <div class="pt-3 pl-3 col-8">
                    <p class="heading_p pt-2 mb-1">Mastercard</p>
                    <p class="mb-1 mt-0">**** **** **** 4352</p>
                </div>
                <div class="col-4 checkmark_div">
                    <i class="fa fa-check"></i>
                </div>
            </div>

            <div class="container-fluid row justify-content-around invoice_work mt-3 mx-auto">
                <div class="col-5">
                    <p class="invoice">invoice</p>
                    <p>HOME</p>
                </div>
                <div class="col-5">
                    <p class="invoice">invoice</p>
                    <p>WORK</p>
                </div>
            </div>
            <div class="my-3">
                <button type="button" class="btn btn-default myvesu_btn" id="pay_button">CHECKOUT</button>
                <button type="submit" class="d-none" id="submit">CHECKOUT</button>
            </div>
        </form>
    </div>


    <script >
        $(document).ready(function () {
            $('.paypal_checkout').click(function () {
                $('.paypal_checkout').removeClass('active_tab');
                $(this).addClass('active_tab');
                $('#payment_method').val($(this).data('value'));
            });
            $('#pay_button').click(function () {
                if($('#payment_method').val()){
                    $('#submit').trigger('click');
                }
            })
        })
    </script>
@endsection





