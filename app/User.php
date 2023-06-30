<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'fcm_token',
        'lat',
        'lng',
        'address',
        'zip',
        'country',
        'state',
        'city',
        'phone',
        'phone',
        'about',
        'avatar',
        'blocked',
        'active',
        'password',
        'locations',
        'fcm_web',
        'brand'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'locations' => 'array',
    ];

    /**
     * provide a many-to-many relationship between User and Role
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param $roles
     * @return bool
     */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized.');
    }

    /**
     * Check multiple roles
     * @param $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * Check one role
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * Get the driver record associated with the user.
     */
    public function driver()
    {
        return $this->hasOne('App\Driver');
    }

    /**
     * @return mixed
     */
    protected function getAuthUserInformation($id) {
        $user = $this->where('id', $id)->first();
        $user['state_name'] = null;
        $user['city_name'] = null;
        if ($user->state != null){
            $user['state_name'] = State::where('id', $user->state)->value('name');
            $user['city_name'] = City::where('id', $user->city)->value('name');
        }
       return $user;
    }

    /**
     * provide a one-to-one relationship with passenger table
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function passenger()
    {
        return $this->hasOne(Passenger::class);
    }

    /**
     * provide a one-to-one relationship with passenger table
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invitation()
    {
        return $this->hasMany(Invitation::class, 'user_id');
    }

    /**
     * provide a many-to-many relationship with rides table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rides()
    {
        return $this->belongsToMany(Ride::class,'join_rides','user_id','ride_id');
    }

    /**
     * provide a many-to-many relationship with notifications table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * user settings
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings(){
        return $this->hasOne(Setting::class);
    }
}
