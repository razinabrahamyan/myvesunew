<?php

namespace App\Http\Controllers\App;

use App\Chat;
use App\Http\Traits\SendNotifications;
use App\Message;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    use SendNotifications;
    public function index($user_id){
        $own_id = Auth::user()->id;
        $messages = Message::where('writer_id',$user_id)->where('getter_id',$own_id)->orWhere('writer_id',$own_id)->where('getter_id',$user_id)->with('writer')->orderBy('created_at','desc')->limit(20)->get();
        $messages = $messages->reverse();
        Message::where('writer_id',$user_id)->where('getter_id',$own_id)->update([
            'seen'=>'1'
        ]);
        Notification::where('user_id',auth()->user()->id)->where('type','message', function ($query)use($user_id){
            $query->where('content->writer_id',$user_id);
        })->update([
            'active'=>'0'
        ]);
        $chat_exists = Chat::where('user_id',$own_id)->where('opponent_id',$user_id)->orWhere('user_id',$user_id)->where('opponent_id',$own_id)->first();
        $chat_name = '';
        $chat_id = 0;
        if (!$chat_exists){
            $chat = Chat::create([
                'user_id'=>$user_id,
                'opponent_id'=>$own_id,
                'name'=>'chat.'.$user_id.'.'.$own_id.'.'.Str::random(10)
            ]);
            $chat_name = $chat->name;
            $chat_id = $chat->id;
        }
        else{
            $chat_name = $chat_exists->name;
            $chat_id = $chat_exists->id;
        }
        return view('app.chat',['messages'=>$messages,'user_id'=>$user_id,'chat_name'=>$chat_name,'is_on_chat_page'=>1,'chat_id'=>$chat_id]);
    }
    public function chats(){
        $chats = Chat::where('user_id',auth()->user()->id)->orWhere('opponent_id',auth()->user()->id)->with('opponent')->with('user')->with('lastMessage')->get();
        return view('app.chats',['chats'=>$chats]);
    }

    public function setToken(Request $request){
        User::where('id',$request->user_id)->first()->update([
            'fcm_web'=>$request->token
        ]);

        return response()->json([
            'success'=>'success'
        ]);
    }

    public function messageSeen(Request $request){
        $user_id = $request->user_id;
        Notification::where('user_id',auth()->user()->id)->where('type','message', function ($query)use($user_id){
            $query->where('content->writer_id',$user_id);
        })->update([
            'active'=>'0'
        ]);
        Message::where('writer_id',$request->user_id)->where('getter_id',auth()->user()->id)->update([
            'seen'=>'1'
        ]);
        return response()->json([
            'success'=>'success'
        ]);
    }

    public function getToken($user_id){
        $token = User::where('id',$user_id)->first()->fcm_web;

        return response()->json([
            'success'=>'success',
            'token'=>$token
        ]);
    }

    public function addMessage(Request $request){
        if($request->message && $request->writer_id && $request->getter_id){
            $message = Message::create([
                'writer_id'=>$request->writer_id,
                'getter_id'=>$request->getter_id,
                'message'=>$request->message,
                'chat_id'=>$request->chat_id
            ]);
            $new_message = Message::where('id',$message->id)->with('writer')->with('getter')->first();
            $token = $new_message->getter->fcm_token;
            $title = auth()->user()->first_name.' '.auth()->user()->last_name;
            $content = [
                'writer_id'=>auth()->user()->id,
                'title'=>$title,
                'body'=>$new_message->message
            ];
            $notification = $this->store($new_message->getter->id,'message',$content);
            $data = [
                'notification_id'=>$notification->id,
                'role'=>'message',
                'title' => $title,
                'body' => $new_message->message,
                'redirect_url'=>'/app/chat/'.auth()->user()->id.'?token='.Str::random(20)
            ];
            $this->send($token,$title,$new_message->message,$data,auth()->user()->avatar);
            return response()->json([
                'success'=>'success',
                'message'=>$new_message,
            ]);
        }
        return response()->json([
            'success'=>'error',
            'error'=>'something went wrong'
        ]);

    }

    public function messagesByAjax($user_id,$iteration,$wrote_messages){
        $iteration = $iteration*20 + $wrote_messages;
        $own_id = Auth::user()->id;
        $messages = Message::where('writer_id',$user_id)->where('getter_id',$own_id)->orWhere('writer_id',$own_id)->where('getter_id',$user_id)->with('writer')->orderBy('created_at','desc')->skip($iteration)->limit(20)->get();
        return response()->json([
            'success'=>'success',
            'messages'=>$messages,
        ]);
    }

    public function getMessages($user_id,$own_id){
        $messages = Message::where('getter_id',$own_id)->where('writer_id',$user_id)->where('seen','0')->with('writer')->get();
        Message::where('getter_id',$own_id)->where('writer_id',$user_id)->where('seen','0')->update([
            'seen'=>'1'
        ]);
        return response()->json([
            'success'=>'success',
            'messages'=>$messages,
        ]);
    }
}
