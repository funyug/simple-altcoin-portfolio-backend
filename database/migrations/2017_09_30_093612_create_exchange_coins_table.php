<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_coins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exchange_id')->unsigned();
            $table->integer('coin_id')->unsigned();
            $table->decimal('volume',18,8)->nullable();
            $table->decimal('last_price',18,8)->nullable();
            $table->decimal("price_24h_ago",18,8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_coins');
    }
}
