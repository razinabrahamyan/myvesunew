<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinRide extends Model
{
    protected $fillable = ['user_id','ride_id','approved'];
}
