<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function getCoin($id) {
        $coin = Coin::getCoinById($id);
        return success($coin);
    }
}
