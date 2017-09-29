<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Device extends Model
{
    public static function getDevice($user_id,$device_id) {
        $device = Device::where('device_id',$device_id)->first();
        if(!$device) {
            $device = new Device();
            $device->device_id = $device_id;
            $device->user_id = $user_id;
            $device->save();
        }
        return $device;
    }
}
