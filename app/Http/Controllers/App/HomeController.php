<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Traits\SendNotifications;
use App\Invitation;
use App\JoinRide;
use App\Mail\ContactMail;
use App\Notification;
use App\Ride;
use App\Role;
use App\User;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('app.home');
    }

    /**
     * return user profile page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(){
        return view('app.profile');
    }

    /**
     * return about app page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about(){
        return view('app.about');
    }

    /**
     * return privacy page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy(){
        return view('app.privacy');
    }

    /**
     * return wallet page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wallet(){
        return view('app.wallet');
    }

    public function delete(){
        JoinRide::where('id','>',0)->delete();
        Notification::where('id','>',0)->delete();
    }

    /**
     * return invitation page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invitation(Ride $ride){
        $passengers = Role::where('name', 'passenger')->first()->users()->get();
        return view('app.invitation', ["passengers" => $passengers, "ride" => $ride]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(Request $request){
        $token = User::where('id', $request->user_id)->value('fcm_token');
        $invitation = Invitation::create([
            "user_id" => $request->user_id,
            "ride_id" => $request->ride_id,
            "inviter" => $request->inviter,
            "invited" => '1'
        ]);
       if ($invitation && $token){
           $title = 'Invitation Request';
           $body = Auth::user()->first_name.' '.Auth::user()->last_name.' invites you to the ride';
           $data = [
               'ride_id'=>$request->ride_id,
               'user_id'=>auth()->user()->id,
               'fcm_token'=>auth()->user()->fcm_token,
               'first_name'=>auth()->user()->first_name,
               'last_name'=>auth()->user()->last_name,
               'redirect_url'=> '/app/ride/'.$request->ride_id.'?token='.Str::random(20),
               'role'=>'invitation',
           ];
           $this->send($token,$title,$body,$data);
           $content = [
               'inviter'=>$request->inviter,
               'ride_id'=>$request->ride_id,
               'title'=>'Invitation Request',
               'body' => Auth::user()->first_name.' '.Auth::user()->last_name.' invites you to the ride'
           ];
           $this->store($request->user_id,'invitation',$content);
           return response()->json([
               'status'=> 'success',
               'message'=> 'Invitation has been sent successfully!'
           ]);
       }else{
           return response()->json([
               'status'=>'error',
               'message'=>'Something`s wrong'
           ]);
       }
    }

    /**
     * return contact page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact(){
        return view('app.contact');
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validation(array $data){
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactUs(Request $request){
        $this->validation($request->all())->validate();
        $data = ['email' => $request->email, 'username' => $request->username, 'subject' => $request->subject, 'message' => $request->message];
        Mail::to('myvesuride@gmail.com')->send(new ContactMail($data));
        if (Mail::failures()) {
            return redirect()->back()->with('error', 'Oops. Something went wrong. Please try again later.');
        }else{
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        }
    }

    public function deleteFromDatabase($type){
        if($type === 'notifications'){
            Notification::where('id','>',0)->delete();
        }

        if($type === 'rides'){
            Ride::where('id','>',0)->delete();
        }

        return back();
    }
}
