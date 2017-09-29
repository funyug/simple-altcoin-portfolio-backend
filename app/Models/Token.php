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
}
