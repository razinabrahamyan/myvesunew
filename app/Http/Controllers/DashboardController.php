<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Destination;
use App\Driver;
use App\DriverCar;
use App\Mail\DriverMail;
use App\Ride;
use App\Passenger;
use App\Role;
use App\State;
use App\User;
use App\VehicleMake;
use App\VehicleModel;
use App\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DashboardController  extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->user()->hasAnyRole(['superadmin', 'admin'])){
            return view('dashboard.index');
        }else{
            return view('welcome');
        }
    }

    /**
     * get administrators list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function administrators(){
        $administrators = Role::where('name', 'admin')->first()->users()->where('user_id', '!=', auth()->user()->id)->paginate(10);
        return view('dashboard.administrators.index', [
            'administrators'   => $administrators,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function administratorView($id){
        $administrator = User::find($id);
        return view('dashboard.administrators.view', ['admin' => $administrator]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $administrator)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$administrator],
            'profile_image' => 'mimes:jpeg,jpg,png,gif|max:4096'
        ]);
    }

    public function administratorUpdate(Request $request, $administrator){
        $this->validator($request->all(), $administrator)->validate();
        try {
            $destinationPath = public_path('/uploads/avatar');
            $image_name = 'default_pic.png';
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $image_name = time().'_'.$image->getClientOriginalName();
                $image->move($destinationPath, $image_name);
            }
            User::where("id", $administrator)->update([
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'blocked' => $request->blocked ? $request->blocked : '0',
                'email' => $request->email,
                'avatar' => $image_name,
            ]);
            $user = User::find($administrator);
            $user->roles()->sync([$request->role], $user->id);
            return redirect()->route('administrators')->with('success', 'Administrator information has been updated successfully!');
        }catch (\Exception $e){
            return redirect()->route('administrators')->with('error', 'Oops. Something went wrong. Please try again later.');
        }
    }

    /**
     * edit administrator by id
     * @param $administrator
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function administratorEdit($administrator){
        return view('dashboard.administrators.edit', [
            'administrator' => User::where('id', $administrator)->where('id', '!=', auth()->user()->id)->first(),
        ]);
    }

    /**
     * @param $administrator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function administratorDelete($administrator){
        if(User::where('id', $administrator)->where('id', '!=', auth()->user()->id)->delete())
            return redirect()->route('administrators')->with('success', 'Administrator has been deleted successfully!');
        else
            return redirect()->route('administrators')->with('error', 'Oops. Something went wrong. Please try again later.');
    }

    /**
     * get users list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users(){
        $users = Role::where('name', 'user')->first()->users()->paginate(10);
        return view('dashboard.users.index', [
            'users'   => $users,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userView($id){
        $user = User::find($id);
        return view('dashboard.users.view', ['user' => $user]);
    }

    /**
     * update user by user id
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userUpdate(Request $request, $user){
        $this->validator($request->all(), $user)->validate();
        try {
            $destinationPath = public_path('/uploads/avatar');
            $image_name = 'default_pic.png';
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $image_name = time().'_'.$image->getClientOriginalName();
                $image->move($destinationPath, $image_name);
            }
            User::where("id", $user)->update([
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'blocked' => $request->blocked ? $request->blocked : '0',
                'email' => $request->email,
                'avatar' => $image_name,
            ]);
            $user = User::find($user);
            $user->roles()->sync([$request->role], $user->id);
            return redirect()->route('users')->with('success', 'User information has been updated successfully!');
        }catch (\Exception $e){
            return redirect()->route('users')->with('error', 'Oops. Something went wrong. Please try again later.');
        }
    }

    /**
     * edit user by id
     * @param $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userEdit($user){
        return view('dashboard.users.edit', [
            'user' => User::where('id', $user)->where('id', '!=', auth()->user()->id)->first(),
        ]);
    }
    /**
     * soft delete user by id
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userDelete($user){
        if(User::where('id', $user)->where('id', '!=', auth()->user()->id)->delete())
            return redirect()->route('users')->with('success', 'User has been deleted successfully!');
        else
            return redirect()->route('users')->with('error', 'Oops. Something went wrong. Please try again later.');
    }

    protected function profileInfoVAlidation(array $data){
        return Validator::make($data, [
            'username' => 'required|string|min:3|max:15',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/[0-9]{9}/|max:20',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max: 30',
            'address' => 'required|string|min:5|max:30',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'about' => 'nullable|string|min:10|max:255',
            'profile_image' => 'mimes:jpeg,jpg,png,gif|max:4096'
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(){
        $user = User::getAuthUserInformation(auth()->id());
        $country = Country::where('name', 'Germany')->with('states')->first();
        return view("dashboard.profile", ['user' => $user, 'country' => $country]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profileUpdate(Request $request){
        $this->profileInfoVAlidation($request->all())->validate();
        $destinationPath = public_path('/uploads/avatar');
        $image_name = 'default_pic.png';
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $image_name = time().'_'.$image->getClientOriginalName();
            $image->move($destinationPath, $image_name);
        }
        User::where('id', auth()->id())->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'zip' => $request->zip,
            'about' => $request->about,
            'avatar' => $image_name,
        ]);
        return back();
    }

    /**
     * return drivers list
     */
    public function driversList(){
        $drivers = Role::where('name', 'driver')->first()->users()->paginate(10);
        return view('dashboard.drivers.index', ["drivers" => $drivers]);
    }

    /**
     * return view edit form by driver id
     * @param $driver
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function driverEdit($driver){
        $driver = User::where('id', $driver)->first();
        $country = Country::where('id', 82)->first();
        $states = State::where('country_id', 82)->get();
        $vehicle_typs = VehicleType::get();
        $vehicle_makes = VehicleMake::get();
        return view("dashboard.drivers.edit",['country'=> $country, 'states' => $states, 'vehicle_typs' => $vehicle_typs, 'vehicle_makes' => $vehicle_makes, "driver" => $driver]);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function driverInfoUpdateValidation(array $data, $driverId, $id, $carId){
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255','unique:users,username,'.$driverId],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$driverId],
            'first_name' => ['required', 'string','regex:/^[a-zA-Z]+$/u', 'max:255'],
            'last_name' => ['required', 'string','regex:/^[a-zA-Z]+$/u', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],
            'country' => ['required', 'not_in:0'],
            'state' => ['required', 'not_in:0'],
            'city' => ['required', 'not_in:0'],
            'phone' => 'required|regex:/[0-9]{9}/|max:20',
            'type' => ['required', 'not_in:0'],
            'make' => ['required', 'not_in:0'],
            'model' => ['required', 'not_in:0'],
            'year' => ['required', 'not_in:0'],
            'color' => ['required', 'not_in:0'],
            'number_of_passenger' => ['required'],
            'number_of_suitcases' => ['required'],
            'licence_number' => ['required', 'string', 'max:255', 'unique:drivers,licence_number,'.$id],
            'vehicle_registration_number' => ['required', 'string', 'max:255', 'unique:driver_cars,vehicle_registration_number,'.$carId],
            'baby_booster_seat' => ['required'],
        ]);
    }

    /**
     * update driver info by id
     * @param Request $request
     * @param $driverId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function driverUpdate(Request $request, $driverId){
        $carId = DriverCar::where('driver_id', $request->driver_id)->value("id");
        $this->driverInfoUpdateValidation($request->all(), $driverId, $request->driver_id, $carId)->validate();
        try {
            if ($request->hasFile('licence_photo')) {
                $licence_photo_path = public_path('/uploads/licence/');
                $licence_photo = $request->file('licence_photo');
                $licence_photo_name = time().'_'.$licence_photo->getClientOriginalName();
                $licence_photo->move($licence_photo_path, $licence_photo_name);
                $licence_photo =  $licence_photo_name;
            }else{
                $licence_photo = $request->old_licence_photo;
            }

            if ($request->hasFile('vehicle_photo')) {
                $vehicle_photo_path = public_path('/uploads/vehicle/');
                $vehicle_photo = $request->file('vehicle_photo');
                $vehicle_photo_name = time().'_'.$vehicle_photo->getClientOriginalName();
                $vehicle_photo->move($vehicle_photo_path, $vehicle_photo_name);
                $vehicle_photo =  $vehicle_photo_name;
            }else{
                $vehicle_photo = $request->old_vehicle_photo;
            }

            User::where("id", $driverId)->update([
                'username' => $request->username,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'zip' => $request->zip,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'phone' => $request->phone,
                'blocked' => $request->blocked ? $request->blocked : '0',
                'about' => $request->about ? $request->about : "",
            ]);

            Driver::where("user_id", $driverId)->update([
                'licence_number' => $request->licence_number,
                'licence_photo' => $licence_photo,
            ]);

            DriverCar::where("driver_id", $request->driver_id)->update([
                'type' => $request->type,
                'make' => $request->make,
                'model' => $request->model,
                'year' => $request->year,
                'color' => $request->color,
                'number_of_passenger' => $request->number_of_passenger,
                'number_of_suitcases' => $request->number_of_suitcases,
                'baby_booster_seat' => $request->baby_booster_seat,
                'additional_info' => $request->additional_info ? $request->additional_info : "",
                'vehicle_registration_number' => $request->vehicle_registration_number,
                'vehicle_photo' => $vehicle_photo,
            ]);
            return redirect()->route('drivers.list')->with('success', 'Driver information has been updated successfully!');
        }catch (\Exception $e){
            return redirect()->route('drivers.list')->with('error', 'Oops. Something went wrong. Please try again later.');
        }
    }

    /**
     * return driver info add form view
     */
    public function driversAdd(){
        $country = Country::where('id', 82)->first();
        $states = State::where('country_id', 82)->get();
        $vehicle_typs = VehicleType::get();
        $vehicle_makes = VehicleMake::get();
       return view("dashboard.drivers.add",['country'=> $country, 'states' => $states, 'vehicle_typs' => $vehicle_typs, 'vehicle_makes' => $vehicle_makes]);
    }


    public function driverView($id){
        $driver = User::find($id);
        $vehicle_types = VehicleType::get();
        $vehicle_makes = VehicleMake::get();
        return view('dashboard.drivers.view', ['driver' => $driver, 'vehicle_types' => $vehicle_types, 'vehicle_makes' => $vehicle_makes]);
    }

    /**
     * return cities by state
     * @param Request $request
     * @return mixed
     */
    public function cities(Request $request){
        $cities = City::where('state_id', State::where('name', $request->state)->value('id'))->get()->toJson();
        return $cities;
    }

    /**
     * return models by make
     * @param Request $request
     * @return mixed
     */
    public function vehicleModels(Request $request){
        $models = VehicleModel::where('make_id', VehicleMake::where("name", $request->make)->value('id'))->get()->toJson();
        return $models;
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function driverInfoValidation(array $data){
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'first_name' => ['required', 'string','regex:/^[a-zA-Z]+$/u', 'max:255'],
            'last_name' => ['required', 'string','regex:/^[a-zA-Z]+$/u', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],
            'country' => ['required', 'not_in:0'],
            'state' => ['required', 'not_in:0'],
            'city' => ['required', 'not_in:0'],
            'phone' => 'required|regex:/[0-9]{9}/|max:20',
            'type' => ['required', 'not_in:0'],
            'make' => ['required', 'not_in:0'],
            'model' => ['required', 'not_in:0'],
            'year' => ['required', 'not_in:0'],
            'color' => ['required', 'not_in:0'],
            'number_of_passenger' => ['required'],
            'number_of_suitcases' => ['required'],
            'licence_number' => ['required', 'string', 'max:255', 'unique:drivers'],
            'vehicle_registration_number' => ['required', 'string', 'max:255', 'unique:driver_cars'],
            'baby_booster_seat' => ['required'],
            'licence_photo' => ['required'],
        ]);
    }

    /**
     * create new driver account
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function driversCreate(Request $request){
        $this->driverInfoValidation($request->all())->validate();
        try {
            if ($request->hasFile('licence_photo')) {
                $licence_photo_path = public_path('/uploads/licence/');
                $licence_photo = $request->file('licence_photo');
                $licence_photo_name = time().'_'.$licence_photo->getClientOriginalName();
                $licence_photo->move($licence_photo_path, $licence_photo_name);
                $licence_photo =  $licence_photo_name;
            }else{
                $licence_photo = 'no_licence_photo.png';
            }

            if ($request->hasFile('vehicle_photo')) {
                $vehicle_photo_path = public_path('/uploads/vehicle/');
                $vehicle_photo = $request->file('vehicle_photo');
                $vehicle_photo_name = time().'_'.$vehicle_photo->getClientOriginalName();
                $vehicle_photo->move($vehicle_photo_path, $vehicle_photo_name);
                $vehicle_photo =  $vehicle_photo_name;
            }else{
                $vehicle_photo = 'no_vehicle_photo.png';
            }

            $password = str_random(8);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'zip' => $request->zip,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'phone' => $request->phone,
                'about' => $request->about ? $request->about : "",
                'password' => Hash::make($password),
            ]);
            $user->roles()->attach(Role::where('name', 'driver')->first());

            $drever = Driver::create([
                'user_id' => $user->id,
                'licence_number' => $request->licence_number,
                'licence_photo' => $licence_photo,
            ]);
            $data = ['email' => $request->email, 'password' => $password];

            Mail::to($request->email)->send(new DriverMail($data));

            DriverCar::create([
                'driver_id' => $drever->id,
                'type' => $request->type,
                'make' => $request->make,
                'model' => $request->model,
                'year' => $request->year,
                'color' => $request->color,
                'number_of_passenger' => $request->number_of_passenger,
                'number_of_suitcases' => $request->number_of_suitcases,
                'baby_booster_seat' => $request->baby_booster_seat,
                'additional_info' => $request->additional_info ? $request->additional_info : "",
                'vehicle_registration_number' => $request->vehicle_registration_number,
                'vehicle_photo' => $vehicle_photo,
            ]);
            return redirect()->route('drivers.list')->with('success', 'Driver information has been created successfully!');
        }catch (\Exception $e){
            return redirect()->route('drivers.list')->with('error', 'Oops. Something went wrong. Please try again later.');
        }
    }

    /**
     * soft delete driver account
     * @param $driver
     * @return \Illuminate\Http\RedirectResponse
     */
    public function driverDelete($driver){
        if(User::where('id', $driver)->delete())
            return redirect()->route('drivers.list')->with('success', 'Driver has been deleted successfully!');
        else
            return redirect()->route('drivers.list')->with('error', 'Oops. Something went wrong. Please try again later.');
    }

    /**
     * return passengers list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function passengers(){
        $passengers = Role::where('name', 'passenger')->first()->users()->paginate(10);
        return view("dashboard.passengers.index", ['passengers' => $passengers]);
    }

    public function passengerEdit($id){
        $states = State::where('country_id', 82)->get();
        $user = User::getAuthUserInformation($id);
        $country = Country::where('id', 82)->first();
        $passenger = Passenger::where('user_id', $id)->first();
        return view('dashboard.passengers.edit', ['user'=> $user, 'country' => $country, 'passenger' => $passenger, "states" => $states]);
    }

    /**
     * @param $passenger
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function passengerView($passenger){
        $user = User::where('id', $passenger)->with('passenger')->first();
        return view('dashboard.passengers.view', ['user' => $user]);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function passengerInfoValidation(array $data){
        return Validator::make($data, [
            'username' => 'required|string|min:3|max:15',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/[0-9]{9}/|max:20',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max: 30',
            'address' => 'required|string|min:5|max:30',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required|numeric',
            'about' => 'nullable|string|min:10|max:255',
            'profile_image' => 'mimes:jpeg,jpg,png,gif|max:4096',
        ]);
    }

    /**
     * @param Request $request
     * @param $passenger
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function passengerUpdate(Request $request, $passenger){
        $this->passengerInfoValidation($request->all())->validate();
        $destinationPath = public_path('/uploads/avatar');
        $image_name = User::where('id', $passenger)->value('avatar');
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $image_name = time().'_'.$image->getClientOriginalName();
            $image->move($destinationPath, $image_name);
        }
        User::where('id', $passenger)->update([
            'username' => $request->username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'zip' => $request->zip,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'phone' => $request->phone,
            'about' => $request->about,
            'avatar' => $image_name
        ]);
        $passenger_id = Passenger::where('user_id', $passenger);
        $passenger_id->delete();

        Passenger::create([
           'user_id' => $passenger,
           'company_name' => $request->company_name,
           'company_address' => $request->company_address,
           'cost_unit' => $request->cost_unit,
           'free_text' => $request->free_text,
        ]);

        return redirect('dashboard/passengers');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passengerDelete($id){
        if(User::where('id', $id)->delete())
            return redirect('dashboard/passengers')->with('success', 'Driver has been deleted successfully!');
        else
            return redirect('dashboard/passengers')->with('error', 'Oops. Something went wrong. Please try again later.');
    }

    /**
     * return online drivers on google map
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function map(){
        $passengers = Role::where('name', 'passenger')->first()->users()->get();
        $drivers = Role::where('name', 'driver')->first()->users()->get();
        $online_drivers = Role::where('name', 'driver')->first()->users()->where('active', "1")->get();
        $rides = Ride::get();
        return view("dashboard.map.index", ["drivers" => $drivers, "online_drivers" => $online_drivers, "passengers" => $passengers, "rides" => $rides]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOnlineDrivers(Request $request){
        if ($request->id) {
            $online_drivers = User::where('id',$request->id)->get();
        }else{
            $online_drivers = Role::where('name','driver')->first()->users;
        }
        return response()->json([
            'drivers'=>$online_drivers
        ]);
    }

    /**
     * get rides list
     */
    public function rides(){
        $rides = Ride::query()->paginate(10);
        return view("dashboard.rides.index", ['rides' => $rides]);
    }

    /**
     * create new ride
     * @param Request $request
     */
    public function rideCreate(Request $request){

    }

    /**
     * return create ride form view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rideAdd(Request $request){
        return view("dashboard.rides.add");
    }

    /**
     * @param $ride
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rideView($ride){
        $ride = Ride::where('id',$ride)->with('passengers')->with('driver')->with('user')->first();
        $countPass = $ride->passengers+$ride->count;
        return view("dashboard.rides.view", ['ride' => $ride,'count'=>$countPass]);
    }

    /**
     * return ride form view
     * @param $ride
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rideEdit($ride){
        $ride = Ride::where('id', $ride)->first();
        $stops = json_decode($ride->stops);
        $length = 0;
        foreach ($stops as $stop){
            if($stop->key > $length){
                $length = $stop->key;
            }
        }
        $destinations=Destination::all();
        return view("dashboard.rides.edit", ['ride' => $ride, 'destinations'=>$destinations,'last_index'=>$length]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function rideUpdate(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'passengers' => 'required|numeric',
            'price' => 'required|numeric',
            'pick_up' => 'required|string|max:50',
            'destination' => 'required|string|max:50',
            'date' => 'required',
            'time' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }
        $image = file_get_contents('http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyCv20gVp7XEbDy4OTN0Sxod2iuEKJjfYeo&center='.$request->pickup_point_lat.','.$request->pickup_point_lng.'&size=1200x600&maptype=roadmap&sensor=false&scale=2&zoom=15&markers=icon|'.$request->pickup_point_lat.','.$request->pickup_point_lng.'');
        $image_name = date('mdYHis').'_'.uniqid().'.png';
        $fp  = fopen(public_path('/uploads/rides/'.$image_name), 'w+');
        fputs($fp, $image);
        fclose($fp);

        Ride::where('id', $id)->update([
            'date' => date('Y-m-d',strtotime($request->date)),
            'time' =>date('H:i:s',strtotime($request->time)),
            'pick_up' => $request->pick_up,
            'pick_up_lat' => $request->pickup_point_lat,
            'pick_up_lng' => $request->pickup_point_lng,
            'destination' => $request->destination,
            'price' => $request->price,
            'passengers' => $request->passengers,
            'suitcase' => $request->suitcase,
            'info' => $request->info,
            'stops' => $request->additionals,
            'baby_seat' => !isset($request->baby_seat) ? "0" : $request->baby_seat,
            'shared' => !isset($request->shared) ? "0" : $request->shared,
            'additional' => !isset($request->stop_check) ? "0" :  $request->stop_check,
            'image'=> $image_name ? $image_name : "bitmap.png",
        ]);
        return response()->json(['success'=> 'success']);

    }

    /**
     * @param $ride
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rideDelete($ride){
        $ride = Ride::find($ride);
        $ride->delete();
        return back()->with(['status' => 'success']);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function change_password_validator(array $data) {
        return Validator::make($data, [
           'old_password' => 'required',
           'password' => 'required|string|confirmed|min:6',
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePass() {
        return view('dashboard.change_pass');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addNewPass(Request $request) {
        $this->change_password_validator($request->all())->validate();
        if (\Hash::check($request->old_password, auth()->user()->password)) {
            User::where('id', auth()->id())
                ->update([
               'password' => bcrypt($request->password)
            ]);
            return redirect('/')->with(['success' => 'The password successfully updated']);
        } else{
            return back()->withErrors(['old_password' => 'The password does not match']);
        }
    }

    public function destinations() {
        $destinations = Destination::all();
        return view('dashboard.destinations.index',['destinations'=>$destinations]);
    }

    public function destinationEdit($id){
        $destination = Destination::where('id',$id)->first();
        return view('dashboard.destinations.edit',['destination'=>$destination]);

    }

    public function destinationUpdate(Request $request,$id){
        Destination::where('id',$id)->first()->update([
            'lat'=>$request->destination_lat,
            'lng'=>$request->destination_lng,
            'address'=>$request->address
        ]);
        return redirect()->route('dashboard.destinations');
    }

    public function destinationDelete($id){
        $destination = Destination::find($id);
        $destination->delete();
        return back()->with(['status' => 'success']);
    }

    public function destinationMake(){
        return view('dashboard.destinations.add');
    }

    public function destinationAdd(Request $request){
        Destination::create([
            'address'=>$request->address,
            'lat'=>$request->destination_lat,
            'lng'=>$request->destination_lng,
        ]);
        return redirect()->route('dashboard.destinations');
    }
}
