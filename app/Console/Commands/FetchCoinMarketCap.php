<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Coin;

class FetchCoinMarketCap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch_coin_market_caps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches market cap of all coins from CoinMarketCap.com';

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
        $response = $client->request('GET',"https://api.coinmarketcap.com/v1/ticker/");
        $coins = json_decode($response->getBody()->getContents());
        foreach($coins as $coin_data) {
            $coin = Coin::getCoin($coin_data->symbol);
            $coin->updateCoin($coin_data);
        }
    }
}
