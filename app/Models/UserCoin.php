<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoin extends Model
{
    public function coin() {
        return $this->belongsTo(Coin::class,'coin_id','id');
    }

    public function portfolio() {
        return $this->belongsTo(Portfolio::class,'portfolio_id','id');
    }

    public static function getCoins($user_id,$portfolio_id) {
        $user_coins = UserCoin::with('coin')->whereHas('portfolio',function($query) use($user_id) {
            $query->where('user_id',$user_id);
        });
        if($portfolio_id) {
            $user_coins = $user_coins->where("portfolio_id",$portfolio_id);
        }
        $user_coins = $user_coins->get();
        return $user_coins;
    }
}
