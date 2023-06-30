<?php

namespace App\Http\Controllers\App\Notification;

use App\Dev;
use App\Http\Traits\SendNotifications;
use App\JoinRide;
use App\Notification;
use App\Ride;
use App\User;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class  NotificationController extends Controller
{
    use SendNotifications;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * return notifications list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $notifications = Notification::where('user_id',Auth::user()->id)->where('active','1')->get();
        foreach ($notifications as $notif){
            $notif->content = json_decode($notif->content);
        }
        return view("app.notifications",['notifications'=>$notifications]);

    }

    /**
     * approving or denying passengers join request
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveJoinRequest(Request $request){
        Dev::create([
            'content'=>json_encode($request->all())
        ]);
        $answer = $request->answer;
        $user_id = $request->user_id;
        $ride_id = $request->ride_id;
        $ride = JoinRide::where('user_id',$user_id)->where('ride_id',$ride_id)->first();
        if($request->notification_id){
            $this->deactivate($request->notification_id);
        }
        if ($answer === 'approve'){
            $ride->update([
                'approved'=>'1'
            ]);
            $this->sendApproveResponse($user_id, $ride_id);
            Ride::where('id',$ride_id)->first()->decrement('count',1);
            return response()->json([
                'success'=>'success',
                'message'=>'Approve registered'
            ]);
        }
        elseif ($answer === 'cancel'){
            $ride->update([
                'approved'=>'0'
            ]);
            $this->sendCancelResponse($user_id);
            return response()->json([
                'success'=>'success',
                'message'=>'Deny registered'
            ]);
        }
        else{
            return response()->json([
                'success'=>'error',
                'redirect_url'=> '/app/rides/',
                'message'=>'Something`s wrong'
            ]);
        }
    }

    /**
     * sends approved joining notification to passenger
     * @param $user_id
     * @param $ride_id
     * @return mixed
     */
    public function sendApproveResponse($user_id, $ride_id){
        $token = User::where('id',$user_id)->first()->fcm_token;
        $content = [
            'ride_id'=> $ride_id,
            'title'=>'Driver approve',
            'body'=>'driver approved your join request for the ride'
        ];
        $notification = $this->store($user_id,'join_approve',$content);
        $data = [
            'role'=>'driver_approved',
            'redirect_url'=> '/app/ride/'.$ride_id.'?token='.Str::random(20),
            'type'=>'approve',
            'notification_id'=>$notification->id
        ];
        return $this->send($token,'Driver approved','Driver approved your join request for the ride',$data);
    }

    /**
     * sends failed joining notification to passenger
     * @param $user_id
     * @return mixed
     */
    public function sendCancelResponse($user_id){
        $token = User::where('id',$user_id)->first()->fcm_token;
        $content = [
            'title'=>'Driver cancel',
            'body'=>'driver canceled your join request for the ride'
        ];
        $notification = $this->store($user_id,'join_cancel',$content);
        $data = [
            'role'=>'driver_canceled',
            'redirect_url'=> '/app/rides/',
            'type'=>'cancel',
            'notification_id'=>$notification->id
        ];
        return $this->send($token,'Driver canceled','Driver canceled your join request for the ride',$data);
    }

    /**
     * approving or canceling users join request from web
     * @param $ride_id
     * @param $user_id
     * @param $answer
     * @param $notification_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function approveFromWeb($ride_id,$user_id,$answer,$notification_id){
        $ride = JoinRide::where('user_id',$user_id)->where('ride_id',$ride_id)->first();
        $this->deactivate($notification_id);
        $this->deactivate($notification_id);
        if($answer === 'approve'){
            $ride->update([
                'approved'=>'1'
            ]);
            $this->sendApproveResponse($user_id, $ride_id);
            Ride::where('id',$ride_id)->first()->decrement('count',1);
            return back()->with('success','Approved successfully');
        }
        elseif ($answer === 'cancel'){
            $ride->update([
                'approved'=>'0'
            ]);
            $this->sendCancelResponse($user_id);
            return back()->with('success','Canceled successfully');
        }
        return back();
    }

    /**
     * deactivating users notification(not to show twice)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function seenNotification(Request $request){
        Dev::create([
            'content'=>json_encode($request->all())
        ]);
        if($request->notification_id){
            $this->deactivate($request->notification_id);
            return response()->json([
                'success'=>'success'
            ]);
        }
        return response()->json([
            'success'=>'error'
        ]);
    }

    /**
     * deactivating users notification(not to show twice) from web
     * @param $ride_id
     * @param $notification_id
     * @param $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function seenNotificationFromWeb($ride_id,$notification_id,$type){
        $this->deactivate($notification_id);
        if ($type === 'approved'){
            $ride = Ride::where('id',$ride_id)->first();
            return  redirect()->route('app.ride',$ride->id);
        }
        elseif ($type === 'canceled'){
            return back();
        }
        return back();
    }


    public function seeDebug(Request $request){
        Dev::create([
            'content'=>json_encode($request->all())
        ]);
    }

}
