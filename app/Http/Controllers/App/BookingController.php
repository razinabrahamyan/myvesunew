<?php

namespace App\Http\Controllers\App;

use App\Destination;
use App\Http\Controllers\Controller;
use App\JoinRide;
use App\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{

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
     * Show the application dashboard.w
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $destinations = Destination::all();
        return view('app.booking',['destinations'=>$destinations]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function booking(Request $request){
        $ride = '';
        $image_name = '';
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date'],
            'pickup_point' => ['required', 'string','max:255'],
            'destination' => ['required'],
            'price' => ['required', 'numeric', 'min:1', 'max:9999'],
            'pick_up_time' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }
        if ($request->second_part){
            /*$image = file_get_contents('http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyCv20gVp7XEbDy4OTN0Sxod2iuEKJjfYeo&center='.$request->pickup_point_lat.','.$request->pickup_point_lng.'&size=1200x600&maptype=roadmap&sensor=false&scale=2&zoom=15&path=color:0x0000ff|weight:5|4&markers=icon|'.$request->pickup_point_lat.','.$request->pickup_point_lng.'');
            $image_name = date('mdYHis').'_'.uniqid().'.png';
            $fp  = fopen(public_path('/uploads/rides/'.$image_name), 'w+');
            fputs($fp, $image);
            fclose($fp);*/
            $image_name = 'https://www.industrialempathy.com/img/remote/ZiClJf-1920w.jpg';
            $ride = Ride::create([
                'share_id'=>$request->user()->id,
                'driver_id'=> auth()->user()->hasRole('driver') ? $request->user()->id : 0,
                'date'=>date('Y-m-d',strtotime($request->date)),
                'passengers'=>$request->passengers,
                'baby_seat'=>$request->baby_check,
                'suitcase'=>$request->suitcase,
                'price'=>$request->price,
                'info'=>$request->additional_info,
                'time'=>date('H:i:s',strtotime($request->pick_up_time)),
                'destination'=>$request->destination,
                'pick_up_lat'=>$request->pickup_point_lat,
                'pick_up_lng'=>$request->pickup_point_lng,
                'pick_up'=>$request->pickup_point,
                'shared'=>$request->share_check,
                'invoice'=>$request->invoice,
                'additional'=> $request->stop_check,
                'stops'=> $request->additionals,
                'count'=>$request->passengers,
                'payment'=>$request->payment,
                'image'=> $image_name ? $image_name : "bitmap.png",
                'type'=> auth()->user()->roles()->first()->name,
                'status'=>'active'
            ]);

            if (auth()->user()->hasRole('passenger')){
                JoinRide::create([
                    'user_id' => auth()->user()->id,
                    'ride_id' => $ride->id
                ]);
            }
        }
        return response()->json(['success'=> 'success', "ride" => $ride]);
    }

}
