<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'RouteController@index');

Auth::routes();


Route::group(['middleware' => ['auth:web', 'role:user']], function () {
   return view('welcome');
});

Route::group(['middleware' => ['auth:web', 'role:superadmin|admin|user']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        /**
         * Users and Permission
         */
        Route::get('/administrators', 'DashboardController@administrators')->name('administrators');
        Route::get('/administrator-edit/{id}', 'DashboardController@administratorEdit')->name('administrator.edit');
        Route::get('/administrator-view/{id}', 'DashboardController@administratorView')->name('administrator.view');
        Route::post('/administrator-update/{id}', 'DashboardController@administratorUpdate')->name('administrator.update');
        Route::delete('/administrator-delete/{id}', 'DashboardController@administratorDelete')->name('administrator.delete');

        Route::get('/users', 'DashboardController@users')->name('users');
        Route::get('/user-edit/{id}', 'DashboardController@userEdit')->name('user.edit');
        Route::get('/user-view/{id}', 'DashboardController@userView')->name('user.view');
        Route::post('/user-update/{id}', 'DashboardController@userUpdate')->name('user.update');
        Route::delete('/user-delete/{id}', 'DashboardController@userDelete')->name('user.delete');

        /**
         * user profile
         */
        Route::get('/profile', 'DashboardController@profile')->name('profile');
        Route::post('/profile-update', 'DashboardController@profileUpdate')->name('profile.update');

        /**
         * User password change
         */
        Route::get('/password-change', 'DashboardController@changePass')->name('change.pass');
        Route::post('/add-new-password', 'DashboardController@addNewPass')->name('add.new.pass');

        /**
         * Drivers CRUD
         */
        Route::get('/drivers-list', 'DashboardController@driversList')->name('drivers.list');
        Route::get('/driver-edit/{id}', 'DashboardController@driverEdit')->name('driver.edit');
        Route::get('/driver-view/{id}', 'DashboardController@driverView')->name('driver.view');
        Route::post('/driver-update/{driver}', 'DashboardController@driverUpdate')->name('driver.update');
        Route::get('/driver-add', 'DashboardController@driversAdd')->name('driver.add');
        Route::post('/driver-create', 'DashboardController@driversCreate')->name('driver.create');
        Route::delete('/driver-delete/{id}', 'DashboardController@driverDelete')->name('driver.delete');

        /**
         * Passengers CRUD
         */
        Route::get('/passengers', 'DashboardController@passengers')->name('passengers');
        Route::get('/passenger-view/{id}', 'DashboardController@passengerView')->name('passenger.view');
        Route::get('/passenger-edit/{id}', 'DashboardController@passengerEdit')->name('passenger.edit');
        Route::post('/passenger-update/{id}', 'DashboardController@passengerUpdate')->name('passenger.update');
        Route::delete('/passenger-delete/{id}', 'DashboardController@passengerDelete')->name('passenger.delete');


        /**
         * show online drivers in google map
         */
        Route::get('/map', 'DashboardController@map')->name('map');
        Route::post('/online-drivers', 'DashboardController@getOnlineDrivers')->name('online.drivers');

        /**
         * get cities by state id
         */
        Route::post('/cities', 'DashboardController@cities')->name('cities');

        /**
         * get vehicle models by make id
         */
        Route::post('/models', 'DashboardController@vehicleModels')->name('models');

        /**
         * Rides CRUD
         */
        Route::get('/rides', 'DashboardController@rides')->name('dashboard.rides');
        Route::get('/radd', 'DashboardController@rideAdd')->name('ride.add');
        Route::post('/ride-create/{id}', 'DashboardController@rideCreate')->name('ride.create');
        Route::get('/ride-view/{id}', 'DashboardController@rideView')->name('ride.view');
        Route::get('/ride-edit/{id}', 'DashboardController@rideEdit')->name('ride.edit');
        Route::post('/ride-update/{id}', 'DashboardController@rideUpdate')->name('ride.update');
        Route::delete('/ride-delete/{id}', 'DashboardController@rideDelete')->name('ride.delete');

        Route::get('/destinations', 'DashboardController@destinations')->name('dashboard.destinations');
        Route::post('/destinations-add', 'DashboardController@destinationAdd')->name('destination.add');
        Route::get('/destination-edit/{id}', 'DashboardController@destinationEdit')->name('destination.edit');
        Route::get('/destination-make', 'DashboardController@destinationMake')->name('destination.make');
        Route::post('/destination-update/{id}', 'DashboardController@destinationUpdate')->name('destination.update');
        Route::delete('/destination-delete/{id}', 'DashboardController@destinationDelete')->name('destination.delete');

    });
});

/**
 * authentication for app
 * required fcm_token
 */
Route::get('/start', 'App\StartController@index')->name('start');
Route::get('/delete', 'App\HomeController@delete');
Route::get('/app/login', 'App\LoginController@showLoginForm')->name('app.loginform');
Route::post('/app/login', 'App\LoginController@login')->name('app.login');
Route::get('/app/logout', 'App\LoginController@logout')->name('app.logout');
Route::get('/app/register', 'App\RegisterController@showRegistrationForm')->name('app.register');
Route::post('/app/register', 'App\RegisterController@register')->name('app.register');
Route::get('/app/get-cities/', 'App\RegisterController@getCities')->name('app.cities');

/**
 * app route group
 * driver middleware group
 * passenger middleware group
 */

Route::group(['middleware' => ['auth:app']], function () {
    Route::get('/app', 'App\HomeController@index')->name('app');

    Route::prefix('app')->group(function () {

        Route::get('/home', 'App\HomeController@index')->name('app.home');
        Route::get('/booking', 'App\BookingController@index')->name('app.booking');

        Route::get('/own-rides', 'App\RidesController@ownRides')->name('app.own.rides');


        Route::get('/rides/{category}', 'App\RidesController@ridesByAjax')->name('app.rides.ajax');

        Route::get('/ride/{ride}', 'App\RidesController@rideById')->name('app.ride');
        Route::post('/book-ride', 'App\BookingController@booking')->name('app.book.ride');
        Route::post('/pike-passenger', 'App\RidesController@pikePassenger')->name('app.pike.passenger');
        Route::post('/start-ride', 'App\RidesController@startTheRide')->name('app.start.ride');
        Route::post('/end-ride', 'App\RidesController@endTheRide')->name('app.end.ride');
        Route::get('/on-the-way/{ride}', 'App\RidesController@onTheWay')->name('app.on_the_way.ride');
        Route::post('/driver-info', 'App\RidesController@driverInfo')->name('app.driver.info');
        Route::get('/driver-ride/{ride}', 'App\RidesController@driverRide')->name('app.driver.ride');
        Route::get('/pick-ride/{ride}', 'App\RidesController@pick')->name('app.pick.ride');
        Route::get('/join-ride/{ride}', 'App\RidesController@join')->name('app.join.ride');
        Route::post('/rate-ride', 'App\RidesController@rate')->name('app.rate.ride');
        Route::get('/profile', 'App\HomeController@profile')->name('app.profile');
        Route::get('/profile-edit', 'App\ProfileController@showEditForm')->name('app.profile.edit');
        Route::post('/profile-update', 'App\ProfileController@updateProfile')->name('app.profile.update');
        Route::get('/profile-edit-cities', 'App\ProfileController@getCities')->name('app.profile.cities');
        Route::get('/settings', 'App\SettingsController@index')->name('app.settings');
        Route::post('/user-settings', 'App\SettingsController@settings')->name('app.user_settings');
        Route::get('/notifications', 'App\Notification\NotificationController@index')->name('app.notifications');
        Route::get('/privacy', 'App\HomeController@privacy')->name('app.privacy');
        Route::get('/about', 'App\HomeController@about')->name('app.about');
        Route::get('/wallet', 'App\HomeController@wallet')->name('app.wallet');
        Route::get('/invitation/{ride}', 'App\HomeController@invitation')->name('app.invitation');
        Route::post('/invite', 'App\HomeController@invite')->name('app.invite');
        Route::get('/contact', 'App\HomeController@contact')->name('app.contact');
        Route::post('/contact-us', 'App\HomeController@contactUs')->name('app.contact_us');

        Route::get('/approve-join-request/{ride_id}/{user_id}/{answer}/{notification_id}', 'App\Notification\NotificationController@approveFromWeb')->name('app.join.approve');
        Route::get('/join-answer/{ride_id}/{notification_id}/{type}', 'App\Notification\NotificationController@seenNotificationFromWeb')->name('app.join.passenger');


        Route::get('/pay-with-paypal','App\CheckoutController@payWithPaypal')->name('payment.paypal');
        Route::get('/payment-good','App\CheckoutController@paypalSuccess')->name('payment.good');
        Route::get('/payment-food','App\CheckoutController@paypalFail')->name('payment.fail');


        Route::get('/checkout/{user_id}/{ride_id}/{notification_id?}', 'App\CheckoutController@index')->name('app.checkout');
        Route::post('/pay', 'App\CheckoutController@pay')->name('app.pay');
        Route::get('/payment-success/{driver}', 'App\CheckoutController@paymentSuccess')->name('app.payment.success');

        Route::get('/chat/{user_id}','App\ChatController@index')->name('app.chat');
        Route::get('/chats','App\ChatController@chats')->name('app.chats');
        Route::get('/messages/{user_id}/{iteration}/{wrote_messages}','App\ChatController@messagesByAjax')->name('app.messages.bring');
        Route::post('/add-web-token','App\ChatController@setToken')->name('app.add.token');
        Route::post('/add-message','App\ChatController@addMessage')->name('app.add.message');
        Route::post('/seen-message','App\ChatController@messageSeen')->name('app.seen.message');
        Route::get('/get-messages/{user_id}/{own_id}','App\ChatController@getMessages')->name('app.get.messages');
        Route::get('/get-web-token/{user_id}','App\ChatController@getToken')->name('app.get.token');

        Route::group(['middleware' => ['role:driver']], function () {
            Route::get('/driver', 'App\Driver\DriverController@index')->name('app.driver');
        });

        Route::group(['middleware' => ['role:passenger']], function () {
            Route::get('/passenger', 'App\Passenger\PassengerController@index')->name('app.passenger');
        });



        Route::get('/delete-from-database/{type}', 'App\HomeController@deleteFromDatabase');
    });
});
