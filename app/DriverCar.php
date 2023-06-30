<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverCar extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'driver_id',
        'type',
        'make',
        'model',
        'year',
        'color',
        'number_of_passenger',
        'baby_booster_seat',
        'number_of_suitcases',
        'additional_info',
        'licence_number',
        'vehicle_photo',
        'vehicle_registration_number'
    ];
    /**
     * Get the driver that owns the car.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }
}
