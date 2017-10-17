<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeCoin extends Model
{
    public $appends = ['text'];

    public function getTextAttribute() {
        return $this->currency->currency_code."-".$this->coin->symbol;
    }

    public static function getCoin($currency,$symbol,$exchange_name) {
        $exchange = Exchange::getExchange($exchange_name);
        $coin = Coin::getCoin($symbol);
        $currency = Currency::getCurrency($currency);
        $exchange_coin = ExchangeCoin::where('exchange_id',$exchange->id)->where('currency_id',$currency->id)->where('coin_id',$coin->id)->first();
        if(!$exchange_coin) {
            $exchange_coin = ExchangeCoin::createCoin($currency->id,$coin->id,$exchange->id);
        }
        return $exchange_coin;
    }

    public static function createCoin($currency_id,$coin_id,$exchange_id) {
        $exchange_coin = new ExchangeCoin();
        $exchange_coin->coin_id = $coin_id;
        $exchange_coin->exchange_id = $exchange_id;
        $exchange_coin->currency_id = $currency_id;
        $exchange_coin->save();
        return $exchange_coin;
    }

    public function coin() {
        return $this->belongsTo(Coin::class,'coin_id','id');
    }

    public function currency() {
        return $this->HasOne(Currency::class,'id','currency_id');
    }

    public function exchange() {
        return $this->HasOne(Exchange::class,'id','exchange_id');
    }

    public function updateCoin($volume,$last_price,$price_24h_ago) {
        $this->volume = $volume;
        $this->last_price = $last_price;
        $this->price_24h_ago = $price_24h_ago;
        $this->save();
    }
}
