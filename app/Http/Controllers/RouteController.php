<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function apiUser(Request $request){
        return $request->user();
    }

    public function index(){
        return redirect()->route("dashboard");
    }
}
