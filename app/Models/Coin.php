<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    public static function getCoin($symbol) {
        $coin = Coin::where("symbol",$symbol)->first();
        if(!$coin) {
            $data = new \stdClass;
            $data->symbol = $symbol;
            $coin = Coin::createCoin($data);
        }
        return $coin;
    }

    public static function createCoin($data) {
        $coin = new Coin();
        $coin->symbol = $data->symbol;
        $coin->name = isset($data->name) ? $data->name : "";
        $coin->last_price = isset($data->price_btc) ? $data->price_btc : 0;
        $coin->total_supply = isset($data->total_supply) ? $data->total_supply : "";
        $coin->market_cap = isset($data->market_cap_usd) ? $data->market_cap_usd : "";
        $coin->save();
        return $coin;
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
