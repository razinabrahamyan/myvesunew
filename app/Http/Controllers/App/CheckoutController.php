<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Traits\SendNotifications;
use App\Ride;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\ExpressCheckout;

class CheckoutController extends Controller
{
    use SendNotifications;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:app');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($user_id, $ride_id,$notification_id = null)
    {
        $ride = Ride::where('id', $ride_id)->first();
        $user = User::where('id', $user_id)->first();
        return view('app.checkout', ['ride' => $ride, 'user' => $user,'notification_id'=>$notification_id]);
    }

    public function pay(Request $request){
        if($request->payment_method === 'paypal'){
            return redirect()->route('payment.paypal',$request);
        }
        $token = User::where('id', $request->driver_id)->first()->fcm_token;
        User::where('id',$request->user_id)->first()->rides()->updateExistingPivot($request->ride_id,['status'=>'paid']);
        $data = [
            'ride_id'=>$request->ride_id,
            'user_id'=>$request->user_id,
            'fcm_token'=>$token,
            'role'=>'passenger_paid',
        ];
        $ride = Ride::where('id',$request->ride_id)->first();
        if($ride->status !== 'ended'){
            $data['redirect_url'] = '/app/driver-ride/'.$request->ride_id.'?token='.Str::random(20);
        }
        $this->send($token,'Passenger Paid','passenger paid.',$data);
        if($request->notification_id){
            $this->deactivate($request->notification_id);
        }
        return redirect()->route('app.payment.success',['driver_id'=>$request->driver_id]);

    }

    public function paymentSuccess($driver_id){
        return view('app.payment_success',['driver_id'=>$driver_id]);
    }

    public function payWithPaypal(Request $request){
        $provider = new ExpressCheckout;
        $data = [];
        $data['items'] = [
            [
                'name' => 'Product 1',
                'price' => 0.05,
                'desc'  => 'Description for product 1',
                'qty' => 1
            ],
            [
                'name' => 'Product 2',
                'price' => 2.5,
                'desc'  => 'Description for product 2',
                'qty' => 2
            ]
        ];

        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.good');
        $data['cancel_url'] = route('payment.fail');

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }

        $data['total'] = $total;
        $response = $provider->setExpressCheckout($data);

        // This will redirect user to PayPal
        return redirect($response['paypal_link']);
    }

    public function paypalSuccess(Request $request){
        $provider = new ExpressCheckout();
        $token = $request->token;
        $response = $provider->getExpressCheckoutDetails($token);
        $PayerID = $request->PayerID;
        $data = [];
        $data['items'] = [
            [
                'name' => 'Product 1',
                'price' => 0.05,
                'desc'  => 'Description for product 1',
                'qty' => 1
            ],
            [
                'name' => 'Product 2',
                'price' => 2.5,
                'desc'  => 'Description for product 2',
                'qty' => 2
            ]
        ];

        $data['invoice_id'] = uniqid();
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.good');
        $data['cancel_url'] = route('payment.fail');

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }

        $data['total'] = $total;
        $response = $provider->doExpressCheckoutPayment($data, $token, $PayerID);
        dd('tralala');
    }
}
