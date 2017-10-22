<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function getCoin($symbol) {
        $coin = Coin::getCoin($symbol,0);
        return success($coin);
    }

    public function getExchanges($symbol) {
        $exchanges = Coin::getExchanges($symbol);
        return success($exchanges);
    }
}
