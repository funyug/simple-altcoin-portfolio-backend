<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    public static function getExchanges() {
        $exchanges = Exchange::where('active',1)->get();
        return $exchanges;
    }

    public static function getExchange($exchange_name) {
        $exchange = Exchange::where('name',$exchange_name)->first();
        if(!$exchange) {
            $exchange = Exchange::createExchange($exchange_name);
        }
        return $exchange;
    }

    public static function createExchange($exchange_name) {
        $exchange = new Exchange();
        $exchange->name = $exchange_name;
        $exchange->active = 1;
        $exchange->save();
    }

}
