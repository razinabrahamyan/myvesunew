<?php

namespace App\Http\Controllers\App;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private function profileValidate(array $data){
        return VAlidator::make($data,[
            'image'=>'nullable|max:10000',
            'first_name'=>'required|string|max:20',
            'last_name'=>'required|string|max:20',
            'country'=>'required|string|max:20',
            'state'=>'required|string|max:20',
            'city'=>'required|string|max:20',
            'phone'=>'nullable|regex:/[0-9]{9}/',
            'about'=>'nullable|string|max:255',
        ]);
    }
    /**
     * return cities by state for editing profile info
     * @param Request $request
     * @return mixed
     */
    public function getCities(Request $request){
        $cities = City::where('state_id', State::where('name', $request->state)->value('id'))->get()->toJson();
        return $cities;
    }

    /**
     * shows profile edit page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditForm(){
        $country = Country::where('name', 'Germany')->with('states')->first();
        return view('app.edit_profile',['country'=>$country]);
    }

    /**
     * updating profile information
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request){
        $this->profileValidate($request->all())->validate();
        $destinationPath = public_path('/uploads/avatar');
        $image_name = Auth::user()->avatar;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'_'.$image->getClientOriginalName();
            $image->move($destinationPath, $image_name);
        }
        User::where('id',Auth::user()->id)->first()->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'country'=>$request->country,
            'state'=>$request->state,
            'city'=>$request->city,
            'phone'=>$request->phone,
            'about'=>$request->about,
            'avatar'=>$image_name
        ]);
        return redirect()->route('app.profile');
    }
}
