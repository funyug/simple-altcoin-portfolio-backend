<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public static function getCurrency($symbol) {
        $currency = Currency::where('currency_code',$symbol)->first();
        if(!$currency) {
            $currency = Currency::createCurrency($symbol);
        }
        return $currency;
    }

    public static function createCurrency($symbol) {
        $currency = new Currency();
        $currency->currency_code = $symbol;
        $currency->save();
        return $currency;
    }
}
