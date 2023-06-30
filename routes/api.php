<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user','App\Http\Controllers\RouteController@apiUser');


Route::post('/setLocation', 'App\Driver\DirectionController@setLocation');
Route::post('/approve-request', 'App\Notification\NotificationController@approveJoinRequest');
Route::post('/notification-seen', 'App\Notification\NotificationController@seenNotification');
Route::post('/setDebug', 'App\Notification\NotificationController@seeDebug');
