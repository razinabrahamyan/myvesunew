<?php

namespace App\Http\Traits;

use App\Notification;
use App\User;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\Auth;

trait SendNotifications {

    /**
     * sends firebase notification
     * @param string $fcm_token
     * @param string $title
     * @param string $body
     * @param array $data
     * @return mixed
     */
    public function send(string $fcm_token,string $title,string $body,array $data,$image = null){
        if($fcm_token){
            $notification = new PushNotification('fcm');
            $brand = User::where("fcm_token", $fcm_token)->value("brand");
            if($brand && $brand === 'Apple'){
                $notification->setApiKey('AAAATNee0JM:APA91bGdOqJgok2DgXcdp7roizwtUyCrr_jAwcClX5Jg8OXyWtW4xb3LqT-63muYXRFVxPf4u9qTF4GYoXzNZhmLX-WKVMuBVuKiOL9lGbU2YCKuE3D2QviZ4HSf3h1tGEqao7DqBS8n');
            }
            else{
                $notification->setApiKey('AAAAOhejbrE:APA91bGPPUxCo_lNaucv283qUWulpSeanuvWmQwOHFB4ZBX26G_BhrWJzBUKabiLkNgfFw--l7A8llDfjQcetl1w3lyPBahJfS7rF49oOo8SoYdLHg2hh92wzg_qtEKh8q3HCzHsnSWt');
            }
            $notification->setDevicesToken($fcm_token);
            $data['image'] = $image? 'https://myvesu.aurosystem.com/uploads/avatar/'.$image : null;
            $notification->setMessage([
                'notification' => [
                    'image'=>  $image? 'https://myvesu.aurosystem.com/uploads/avatar/'.$image : null,
                    'title' => $title,
                    'body'=> $body,
                    'sound' => 'gotdone'
                ],
                'webpush'=> [
                    'headers'=> [
                        'Urgency'=>'high'
                    ]
                ],
                'data'=>$data
            ]);
            $notification->setConfig([
                'priority'=>'high'
            ]);
            return $notification->send()->getFeedback();
        }else{
            return 0;
        }

    }

    /**
     * stores notification in db
     * @param $user_id
     * @param $type
     * @param $content
     * @param string $is_active
     * @return mixed
     */
    public function store($user_id,$type,$content,$is_active = '1'){

        return Notification::create([
            'user_id'=>$user_id,
            'type'=>$type,
            'content'=>json_encode($content),
            'active'=>$is_active
        ]);
    }


    public function deactivate($id){
        return Notification::where('id',$id)->first()->update([
            'active'=>'0'
        ]);
    }
}

