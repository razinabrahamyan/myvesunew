<?php

namespace App\Http\Controllers\App;

use App\City;
use App\Country;
use App\Passenger;
use App\Role;
use App\State;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller   FROM FRONT
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest:app');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'last_name' => ['nullable','string', 'min:2'],
            'address' => ['nullable','string', 'max:255'],
            'zip_code' => ['nullable', 'regex:/\b\d{5}\b/'],
            'city' => ['nullable', 'string', 'min:2','max:147'],
            'number' => ['nullable','regex:/[0-9]{9}/'],
        ]);
    }

    /**
     * Show the application registration form.
     * @param $fcm_token
     * @return Factory|View
     */
    public function showRegistrationForm(Request $request)
    {
        $country = Country::where('name', 'Germany')->with('states')->first();
        return view('app.auth.register', ["fcm_token" => $request->fcm_token, "lat" => $request->lat, "lng" => $request->lng, "country" => $country]);
    }

    /**
     * return cities by state
     * @param Request $request
     * @return mixed
     */
    public function getCities(Request $request){
        $cities = City::where('state_id', State::where('name', $request->state)->value('id'))->get()->toJson();
        return $cities;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @param string $fcm_token
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'zip' => $data['zip'],
            'password' => Hash::make($data['password']),
            'fcm_token'=>$data["fcm_token"],
            'lat'=>$data["lat"],
            'lng'=>$data["lng"],
        ]);

        $user->roles()->attach(Role::where('name', 'passenger')->first());
        return $user;
    }

    /**
     * gesiters a new user
     * @param Request $request
     * @return RedirectResponse
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all(), $request)));
        $this->company($request->all(),$user->id);
        $this->guard('app')->login($user);
        return redirect()->route('app.home');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('app');
    }

    /**
     * Create a new passenger instance with user`s additional information.
     * @param array $data
     * @param $user_id
     * @return mixed
     */
    protected function company(array $data,$user_id)
    {
        $user = Passenger::create([
            'user_id' => $user_id,
            'company_name' => $data['company_name'],
            'company_address' => $data['company_address'],
            'free_text' => $data['free_text'],
            'cost_unit' => $data['cost_unit'],
        ]);

        return $user;
    }


}
