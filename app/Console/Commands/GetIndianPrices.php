<?php

namespace App\Console\Commands;

use App\Models\ExchangeCoin;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetIndianPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_indian_prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets prices of indian exchanges';

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
        $this->getCoinsecurePrices($client);
        $this->getZebpayPrices($client);
        $this->getPocketBitsPrices($client);
    }

    public function getZebpayPrices($client) {
        try {
            $response = $client->request("GET", 'https://api.zebpay.com/api/v1/ticker?currencyCode=INR');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("INR", "BTC", "Zebpay");
            $exchange_coin->updateCoin($response->volume * $response->market, $response->market, null);
        }
        catch(\Exception $e) {
            Log::error($e);
        }
    }

    public function getCoinsecurePrices($client) {
        try {
            $response = $client->request("GET", 'https://api.coinsecure.in/v1/exchange/ticker');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("INR", "BTC", "CoinSecure");
            $exchange_coin->updateCoin($response->message->fiatvolume/100, $response->message->lastPrice/100, null);
        }
        catch(\Exception $e) {
            Log::error($e);
        }
    }

    public function getPocketBitsPrices($client) {
        try {
            $response = $client->request("GET", 'https://pocketbits.co.in/Index/getBTCRate');
            $response = json_decode($response->getBody()->getContents());
            $exchange_coin = ExchangeCoin::getCoin("INR", "BTC", "PocketBits");
            $exchange_coin->updateCoin(null, ($response->BTC_BuyingRate + $response->BTC_SellingRate)/2, null);
        }
        catch(\Exception $e) {
            Log::error($e);
        }
    }
}
