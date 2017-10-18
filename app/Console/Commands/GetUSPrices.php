<?php

namespace App\Console\Commands;

use App\Models\ExchangeCoin;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetUSPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_us_prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets US bitcoin prices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();
        $this->getBitfinexBTCPrice($client);
        $this->getBitfinexETHPrice($client);
        $this->getBitfinexLTCPrice($client);
        $this->getGDAXBTCPrice($client);
        $this->getGDAXETHPrice($client);
        $this->getGDAXLTCPrice($client);
    }

    public function getBitfinexBTCPrice($client) {
        try {
            $response = $client->request("GET", 'https://api.bitfinex.com/v1/pubticker/btcusd');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "BTC", "Bitfinex");
            $exchange_coin->updateCoin($response->volume, $response->last_price, null);
        }
        catch(\Exception $e) {
            Log::error($e);
        }
    }

    public function getBitfinexLTCPrice($client) {
        try {
            $response = $client->get('https://api.bitfinex.com/v1/pubticker/ltcusd');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "LTC", "Bitfinex");
            $exchange_coin->updateCoin($response->volume, $response->last_price, null);
        }
        catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function getBitfinexETHPrice($client) {
        try {
            $response = $client->get('https://api.bitfinex.com/v1/pubticker/ethusd');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "ETH", "Bitfinex");
            $exchange_coin->updateCoin($response->volume, $response->last_price, null);
        }
        catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function getGDAXBTCPrice($client) {
        try {
            $response = $client->get('https://api.gdax.com/products/BTC-USD/ticker');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "BTC", "GDAX");
            $exchange_coin->updateCoin($response->volume, $response->price, null);
        }
        catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function getGDAXLTCPrice($client) {
        try {
            $response = $client->get('https://api.gdax.com/products/LTC-USD/ticker');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "LTC", "GDAX");
            $exchange_coin->updateCoin($response->volume, $response->price, null);
        }
        catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function getGDAXETHPrice($client) {
        try {
            $response = $client->get('https://api.gdax.com/products/ETH-USD/ticker');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "ETH", "GDAX");
            $exchange_coin->updateCoin($response->volume, $response->price, null);
        }
        catch (\Exception $e) {
            Log::error($e);
        }
    }
}
