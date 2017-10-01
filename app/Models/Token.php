<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Token extends Model
{
    public static function createToken($user_id,$device_id) {
        $device = Device::getDevice($user_id,$device_id);
        $token = new Token();
        $token->access_token = str_random(160);
        $token->device_id = $device->id;
        $token->user_id = $user_id;
        $token->save();
        return $token->access_token;
    }

    public static function getToken($token) {
        $token = Token::where('access_token',$token)->where("valid",1)->first();
        return $token;
    }

    public function user() {
        return $this->belongsTo('App\User','user_id','id');
    }
}
