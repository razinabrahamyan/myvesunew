<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'passengers',
        'baby_seat',
        'suitcase',
        'info',
        'date',
        'time',
        'price',
        'pick_up',
        'count',
        'destination',
        'additional',
        'shared',
        'payment',
        'stops',
        'type',
        'share_id',
        'driver_id',
        'image',
        'pick_up_lat',
        'pick_up_lng',
        'invoice',
        'status'
    ];

    /**
     * provide a one-to-many relationship with passenger table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'share_id');
    }

    /**
     * provide a many-to-many relationship with users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function passengers(){
        return $this->allPassengers()->wherePivot('approved','=','1');
    }

    /**
     * provide a many-to-many relationship with users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allPassengers(){
        return $this->belongsToMany(User::class,'join_rides','ride_id','user_id')->withPivot('approved', 'status');
    }

    /**
     * provide a many-to-one relationship with users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver(){
        return $this->belongsTo(User::class,'driver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destination(){
        return $this->belongsTo(Destination::class,'destination');
    }

}
