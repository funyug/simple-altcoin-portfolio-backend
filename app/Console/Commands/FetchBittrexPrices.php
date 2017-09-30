<?php

namespace App\Console\Commands;

use App\Models\ExchangeCoin;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class FetchBittrexPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch_bittrex_prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $response = $client->request('GET',"https://bittrex.com/api/v1.1/public/getmarketsummaries");
        $response = json_decode($response->getBody()->getContents());
        if(isset($response->result)) {
            $coins = $response->result;
            foreach ($coins as $coin_data) {
                if(strpos($coin_data->MarketName,"BTC-") === 0) {
                    $symbol = str_replace("BTC-","", $coin_data->MarketName);
                    $exchange_coin = ExchangeCoin::getCoin($symbol,"Bittrex");
                    $exchange_coin->updateCoin($coin_data->Volume,$coin_data->Last,$coin_data->PrevDay);
                }
            }
        }
    }
}
