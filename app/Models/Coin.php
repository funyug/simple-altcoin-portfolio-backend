<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Coin extends Model
{
    public static function getCoin($symbol) {
        $coin = Coin::where("symbol",$symbol)->first();
        if(!$coin) {
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

    public function tags() {
        return $this->belongsToMany(Tag::class,'tag_coin','tag_id','coin_id')->wherePivot('user_id',Auth::user()->id);
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
}
