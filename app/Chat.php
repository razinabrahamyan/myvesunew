<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['name','user_id','opponent_id'];


    public function lastMessage(){
        return $this->hasOne(Message::class)->latest();
    }

    public function messages(){
        return $this->hasOne(Message::class)->latest();
    }

    public function opponent(){
        return $this->belongsTo(User::class,'opponent_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }


}
