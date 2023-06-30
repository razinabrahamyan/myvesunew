<?php

namespace App\Http\Controllers\App\Driver;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DirectionController extends Controller
{
    /**
     * stores user`s location in db
     * @param Request $request
     * @return JsonResponse
     */
    public function setLocation(Request $request){
       $user = User::where('fcm_token', $request->fcm_token)->update([
            'lat' => $request->latitude,
            'lng' => $request->longitude
        ]);
       if ($user) {
           return response()->json([
               'result' => 'success',
           ]);
       }
    }
}
