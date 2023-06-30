<?php

namespace App\Http\Controllers\App\Driver;

use App\Http\Controllers\Controller;

class DriverController extends Controller
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

    }

}
