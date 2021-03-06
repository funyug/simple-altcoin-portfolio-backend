<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Coin extends Model
{
    public static function getCoin($symbol,$create_coin = 1) {
        $coin = Coin::with('currencies')->where("symbol",$symbol)->first();
        if(!$coin && $create_coin == 1) {
            $coin = Coin::createCoin($symbol);
        }
        return $coin;
    }

    public static function createCoin($symbol) {
        $coin = new Coin();
        $coin->name = "";
        $coin->symbol = $symbol;
        $coin->save();
        return $coin;
    }

    public static function getExchanges($symbol) {
        $coin = Coin::getCoin($symbol,0);
        if(!$coin) {
            return [];
        }

        $coin->load('pairs.exchange');

        return $coin->pairs;
    }

    public function tags() {
        return $this->belongsToMany(Tag::class,'tag_coin','tag_id','coin_id')->wherePivot('user_id',Auth::user()->id);
    }

    public function pairs() {
        return $this->hasMany(ExchangeCoin::class,'coin_id','id');
    }

    public function updateCoin($data) {
        $this->symbol = $data->symbol;
        $this->last_price = $data->price_btc;
        $this->total_supply = $data->total_supply;
        $this->market_cap = $data->market_cap_usd;
        $this->name = $data->name;
        $this->save();
        return $this;
    }

    public function currencies() {
        return $this->hasMany(ExchangeCoin::class,'coin_id','id')->groupBy('currency_id')->select(DB::raw("id,coin_id,currency_id,avg(last_price) as avg_price"));
    }
}
