<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    /**
     * return States
     *
     * @return mixed
     */
    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }

}
