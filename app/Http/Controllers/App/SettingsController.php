<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $setting = Setting::where("user_id", auth()->user()->id)->first();
        return view('app.settings', ['setting' => $setting]);
    }

    public function settings(Request $request){
        $setting = Setting::where("user_id", auth()->user()->id)->first();
        if ($setting){
            $settings = Setting::where("user_id", auth()->user()->id)->update([
                'night_mode' => $request->night_mode
            ]);
        }else{
            $settings = Setting::create([
                "user_id" => auth()->user()->id,
                'night_mode' => $request->night_mode
            ]);
        }
        if ($settings){
            return response()->json([
                'status'=>'success',
                'message'=>'Settings has been updated successfully!'
            ]);
        }else{
            return response()->json([
                'status'=>'error',
                'message'=>'Oops. Something went wrong. Please try again later.'
            ]);
        }
    }
}
