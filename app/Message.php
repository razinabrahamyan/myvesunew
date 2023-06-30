<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['writer_id','getter_id','message','chat_id'];

    public function getter(){
        return $this->belongsTo(User::class,'getter_id');
    }

    public function writer(){
        return $this->belongsTo(User::class,'writer_id');
    }

    public function chat(){
        return $this->belongsTo(Chat::class,'chat_id');
    }
}
