<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    /**
     * return cities
     * we can not use hasManyThrough here cuz some of countries do not have states.
     *
     * @return void
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'state_id');
    }

}
