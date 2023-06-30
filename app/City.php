<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Continent of country
     *
     * @return Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * belongs to state
     *
     * @return State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
