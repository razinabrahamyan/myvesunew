<?php

namespace App\Http\Controllers\App;

use App\Driver;
use App\Http\Controllers\Controller;
use App\Http\Traits\SendNotifications;
use App\JoinRide;
use App\Notification;
use App\Ride;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RidesController extends Controller
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
     * Show the application dashboard.w
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rides = Ride::with('user')->get();
        return view('app.rides',['rides'=>$rides]);
    }
    /**
     * @param Ride $ride
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function driverRide(Ride $ride){
        $ride = Ride::where('id',$ride->id)->with('destination')->with('passengers')->first();
        $driver = User::where('id', $ride->driver_id)->first();
        $join_rides = Ride::where('id', $ride->id)->with('passengers')->first();
        if($ride->status === 'ended'){
            return redirect()->route('app.own.rides');
        }
        return view('app.driver_ride',['ride' => $ride, 'driver' => $driver, 'join_rides' => $join_rides]);
    }

    /**
     *  get ride by ride id
     * @param Ride $ride
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function rideById(Ride $ride){
        $join_rides = '';
        $driver = User::where('id', $ride->driver_id)->first();
        $ride = Ride::where('id', $ride->id)->with('passengers')->with('destination')->first();
        if($ride->status === 'is_on'){
            $join_rides = Ride::where('id', $ride->id)->with('passengers')->first();
            return view('app.driver_ride',['ride' => $ride, 'driver' => $driver, 'join_rides' => $join_rides]);
        }elseif ($ride->status === 'active' || $ride->status === 'ended'){
            return view('app.ride',['ride' => $ride, 'driver' => $driver]);
        } else return redirect()->route('app.own.rides');

    }
    public function ridesByAjax($category){
        if ($category === 'own_rides'){
            $my_rides = Ride::where('share_id',Auth::user()->id)->where('status','!=','ended')->with('user')
                ->with(['driver' => function ($query) {
                    $query->with(['driver' => function ($driver){
                        $driver->with('cars');
                    }]);
                }])->get();
            return response()->json([
                'success'=>'success',
                'rides'=>$my_rides
            ]);
        }elseif ($category === 'open_rides'){
            $matchIds = JoinRide::where('user_id', Auth::user()->id)->whereIn('approved',['0','1'])->pluck('ride_id')->toArray();
            $is_driver = auth()->user()->hasrole('driver')? true : false;
            $open_rides = '';
            if($is_driver){
                $open_rides = Ride::where('driver_id', 0)->with('user')->get();
            }else{
                $open_rides = Ride::where('shared','1')->where('share_id', '!=', Auth::user()->id)->whereNotIn('id', $matchIds)->where('count','>',0)->where('shared','1')->where('status','!=','ended')->with('user')
                    ->with(['driver' => function ($query) {
                        $query->with(['driver' => function ($driver){
                            $driver->with('cars');
                        }]);
                    }])->get();
            }
            return response()->json([
                'success'=>'success',
                'rides'=>$open_rides
            ]);
        }elseif ($category === 'joined_rides'){
            $acceptedIds = JoinRide::where('user_id', Auth::user()->id)->where('approved','1')->pluck('ride_id')->toArray();
            $joined_rides = Ride::whereIn('id',$acceptedIds)->where('status','!=','ended')->with('user')
                ->with(['driver' => function ($query) {
                    $query->with(['driver' => function ($driver){
                        $driver->with('cars');
                    }]);
                }])->get();
            return response()->json([
                'success'=>'success',
                'rides'=>$joined_rides
            ]);
        }
        return response()->json([
            'success'=>'error',
            'error'=>'invalid category'
        ]);
    }



    public function ownRides (){
        $my_rides = Ride::where('share_id',Auth::user()->id)->where('status','!=','ended')->with('user')
            ->with(['driver' => function ($query) {
                $query->with(['driver' => function ($driver){
                    $driver->with('cars');
                }]);
            }])->get();
        return view('app.rides',['rides' => $my_rides,'category'=>'own_rides']);
    }


    /**
     * driver picks a ride
     * @param $ride_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pick(Ride $ride){
        if($ride->count > 0){
            Ride::where('id',$ride->id)->first()->update([
                'driver_id'=>Auth::guard('app')->user()->id
            ]);
        }
        return back()->with('success', 'Picked successfully');
    }

    /**
     * joining passenger to the ride
     * @param Ride $ride
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join(Ride $ride){
        if($ride->driver_id){
            $user = User::where('id', $ride->driver_id)->first();
            $token = $user->fcm_token;
            $title = 'Passenger Join Attempt';
            $body = Auth::user()->first_name.' '.Auth::user()->last_name.' wants to join to your ride';
            $content = [
                'user_id'=>auth()->user()->id,
                'ride_id'=>$ride->id,
                'title'=>'Passenger Join Attempt',
                'body'=>$body
            ];
            $notification = $this->store($ride->driver_id,'join_attempt',$content);
            $data = [
                'ride_id'=>$ride->id,
                'user_id'=>auth()->user()->id,
                'notification_id'=>$notification->id,
                'role'=>'join_attempt',
                'title' => 'Passenger Join Attempt',
                'body' => Auth::user()->first_name.' '.Auth::user()->last_name.' wants to join to your ride'
            ];
            $this->send($token,$title,$body,$data,auth()->user()->avatar);

            auth()->user()->rides()->attach($ride,['approved'=>'wait']);
            return back()->with('success', 'Join request is sent');
        }else{
            return back()->with('error', 'You can`t join this ride.');
        }
    }

    /**w
     * @param Ride $ride
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function onTheWay(Ride $ride){
        $driver = User::where('id', $ride->driver_id)->first();
        $ride = Ride::where('id', $ride->id)->with('passengers')->first();
        $join_rides = JoinRide::where('user_id', auth()->user()->id)->where('ride_id', $ride->id)->first();
        return view('app.on_the_way',['ride' => $ride, 'driver' => $driver, 'join_rides' => $join_rides]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function driverInfo(Request $request){
        $driver = User::where('id', $request->id)->first();
        $car = $driver->driver()->first()->cars()->first();
        return response()->json(['success'=> 'success', "driver" => $driver, "car" => $car]);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function pikePassenger(Request $request){
        if ($request->type == "ended"){
            $token = User::where('id', $request->user_id)->first()->fcm_token;
            $notification = $this->store($request->user_id,'checkout',[]);
            $content = [
                'redirect_url'=>'/app/checkout/'.$request->user_id.'/'.$request->ride_id.'/'.$notification->id,
                'title' => 'checkout',
                'body'=> 'Your ride was ended please checkout for this ride'
            ];
            Notification::where('id',$notification->id)->first()->update([
                'content'=>json_encode($content)
            ]);
            $data = [
                'ride_id'=> $request->ride_id,
                'user_id'=> $request->user_id,
                'fcm_token'=> $token,
                'redirect_url'=> '/app/checkout/'.$request->user_id.'/'.$request->ride_id.'/'.$notification->id,
                'role'=>'passenger_checkout',
            ];
            $this->send($token,'End of ride','Your ride was ended please checkout for this ride',$data);
        }

        $data['join_ride'] = JoinRide::where('ride_id', $request->ride_id)->where('user_id', $request->user_id)->update([
            "status" => $request->type
        ]);
        $data['ride'] = JoinRide::where('ride_id', $request->ride_id)->where('user_id', $request->user_id)->first();
        return json_encode($data);
    }

    /**
     * driver rating
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rate(Request $request){
        $driver = Driver::where('user_id',$request->driver_id)->first();
        $rating = $driver->rating;
        $count = $driver->raters_count;
        if($rating){
            $rating = $rating*$count;
            $rating = $rating + $request->value;
            $count++;
            $rating = $rating/$count;
        }
        else{
            $rating = $request->value;
            $count++;
        }
        $driver = Driver::where('user_id',$request->driver_id)->first()->update([
            'rating'=>$rating,
            'raters_count'=>$count
        ]);
        return redirect()->route('app.own.rides');
    }

    public function startTheRide(Request $request){
        $ride = Ride::where('id',$request->ride_id)->first();
        if($ride){
            $ride->update([
                'status'=>'is_on'
            ]);
        }
        return response()->json([
            'success'=>'success',
        ]);
    }

    public function endTheRide(Request $request){
        $ride = Ride::where('id',$request->ride_id)->first();
        if($ride){
            $ride->update([
                'status'=>'ended'
            ]);
        }
        return response()->json([
            'success'=>'success',
        ]);
    }


}
