<?php

namespace App\Console\Commands;

use App\Models\ExchangeCoin;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

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
        try {
            $response = $client->request("GET", 'https://api.bitfinex.com/v1/pubticker/btcusd');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "BTC", "Bitfinex");
            $exchange_coin->updateCoin($response->volume, $response->last_price, null);
        }
        catch(\Exception $e) {

        }

        try {
            $response = $client->get('https://api.bitfinex.com/v1/pubticker/ltcusd');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "LTC", "Bitfinex");
            $exchange_coin->updateCoin($response->volume, $response->last_price, null);
        }
        catch (\Exception $e) {

        }

        try {
            $response = $client->get('https://api.bitfinex.com/v1/pubticker/ethusd');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "ETH", "Bitfinex");
            $exchange_coin->updateCoin($response->volume, $response->last_price, null);
        }
        catch (\Exception $e) {

        }

        try {
            $response = $client->get('https://api.gdax.com/products/BTC-USD/ticker');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "BTC", "GDAX");
            $exchange_coin->updateCoin($response->volume, $response->price, null);
        }
        catch (\Exception $e) {

        }

        try {
            $response = $client->get('https://api.gdax.com/products/ETH-USD/ticker');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "ETH", "GDAX");
            $exchange_coin->updateCoin($response->volume, $response->price, null);
        }
        catch (\Exception $e) {

        }

        try {
            $response = $client->get('https://api.gdax.com/products/LTC-USD/ticker');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("USD", "LTC", "GDAX");
            $exchange_coin->updateCoin($response->volume, $response->price, null);
        }
        catch (\Exception $e) {

        }

    }
}
