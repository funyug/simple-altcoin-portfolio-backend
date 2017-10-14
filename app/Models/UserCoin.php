<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoin extends Model
{
    public function exchange_coin()
    {
        return $this->belongsTo(ExchangeCoin::class, 'coin_id', 'id');
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id', 'id');
    }

    public static function getUserCoins($user_id, $portfolio_id)
    {
        $user_coins = UserCoin::with('coin')->whereHas('portfolio', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        });
        if ($portfolio_id) {
            $user_coins = $user_coins->where("portfolio_id", $portfolio_id);
        }
        $user_coins = $user_coins->get();
        return $user_coins;
    }

    public static function createUserCoins($request)
    {
        $user_coin = new UserCoin();
        $user_coin->amount = $request->amount;
        $user_coin->entry_price = $request->entry_price;
        $user_coin->exit_price = $request->exit_price;
        $user_coin->portfolio_id = $request->portfolio_id;
        $user_coin->coin_id = $request->coin_id;
        $user_coin->save();
        return $user_coin;
    }

    public static function getUserCoin($user_id, $portfolio_id)
    {
        $user_coin = UserCoin::whereHas("portfolio", function ($query) use($user_id) {
            $query->where('user_id', $user_id);
        })->where('id', $portfolio_id)->first();
        return $user_coin;
    }

    public function updateUserCoin($request) {
        $this->portfolio_id = $request->portfolio_id;
        $this->amount = $request->amount;
        $this->entry_price = $request->entry_price;
        $this->exit_price = $request->exit_price;
        $this->save();
        return $this;
    }

    public function deleteUserCoin() {
        $this->delete();
        return $this;
    }

}
