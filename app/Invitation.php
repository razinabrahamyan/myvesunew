<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'ride_id',
        'invited',
        'inviter',
        'accord',
    ];
}
