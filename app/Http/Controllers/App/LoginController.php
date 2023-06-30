<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/app';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:app')->except('logout');
    }

    /**
     * Show the application's login form.
     * @param $fcm_token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm(Request $request)
    {
        return view('app.auth.login', ["fcm_token" => $request->fcm_token, "lat" => $request->lat, "lng" => $request->lng,'brand'=>$request->brand]);
    }


    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Handle a login request to the application.
     * @param Request $request
     * @param $fcm_token
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Send the response after the user was authenticated.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $user = User::where('id', $this->guard()->user()->id)->first();
        if($user && $user->blocked === '0') {
            User::where("id", $user->id)->update([
                'active' => '1',
                'fcm_token' => $request->fcm_token,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'brand'=>$request->brand
            ]);
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
        }else{
            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect()->route('app.login', ["fcm_token" => $request->fcm_token, "lat" => $request->lat, "lng" => $request->lng])->with('error', 'Your account is temporarily blocked for login!');
        }
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('app');
    }

    /**
     * Log the user out of the application.
     * @param Request $request
     * @param $fcm_token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $user = User::where('id',$this->guard()->user()->id)->first();
        $user ->update([
            'active'=>'0'
        ]);
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('app.login', ["fcm_token" => $request->fcm_token, "lat" => $request->lat, "lng" => $request->lng,"brand"=>$request->brand])->with('status','You have been logged out!');
    }
}
