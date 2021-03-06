<?php

namespace App\Http\Controllers\Api;

use App\Models\Exchange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExchangeController extends Controller
{
    public function getExchanges() {
        $exchanges = Exchange::getExchanges();
        return success($exchanges);
    }

    public function getExchangeCoins($id) {
        $exchange = Exchange::getExchangeCoins($id);
        return success($exchange);
    }
}
