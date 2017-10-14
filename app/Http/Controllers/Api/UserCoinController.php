<?php

namespace App\Http\Controllers\Api;

use App\Models\Coin;
use App\Models\Portfolio;
use App\Models\UserCoin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserCoinController extends Controller
{
    public function getUserCoins(Request $request) {
        $validator = $this->validateGetUserCoins($request);
        if($validator->passes()) {
            $user = Auth::user();
            $user_coins = UserCoin::getUserCoins($request->portfolio_id,$user->id);
            return success($user_coins);
        }
        return fail(["errors" => $validator->errors()]);
    }

    public function postUserCoins(Request $request) {
        $validator = $this->validatePostUserCoins($request);
        if($validator->passes()) {
            $user = Auth::user();
            $user_coins = UserCoin::createUserCoins($request);
            return success($user_coins);
        }
        return fail(["errors" => $validator->errors()]);
    }

    public function getUserCoin($id) {
        $user = Auth::user();
        $user_coin = UserCoin::getUserCoin($user->id,$id);
        return success($user_coin);
    }

    public function updateUserCoin($id,Request $request) {
        $validator = $this->validateUpdateUserCoin($request);
        $user_coin = new UserCoin();
        $validator->after(function($validator) use($id,&$user_coin,$request) {
            if(count($validator->errors()->all()) < 1) {
                $user = Auth::user();
                $user_coin = $user_coin->where('id',$id)->whereHas('portfolio',function($query) use($user,$request) {
                    $query->where('user_id',$user->id);
                })->first();
                if($user_coin == null) {
                    $validator->errors()->add("invalid_coin","Coin not found");
                }
                $portfolio = Portfolio::where('id',$request->portfolio_id)->where('user_id',$user->id)->first();
                if(!$portfolio) {
                    $validator->errors()->add("invalid_portfolio","Portfolio not found");
                }
            }
        });

        if($validator->passes()) {
            $user_coin = $user_coin->updateUserCoin($request);
            return success($user_coin);
        }
        return fail(["errors"=>$validator->errors()]);
    }

    public function deleteUserCoin($id,Request $request) {
        $validator = $this->validateDeletePortfolio($request);
        $user_coin = new UserCoin();
        $validator->after(function($validator) use($id,&$user_coin) {
            if(count($validator->errors()->all()) < 1) {
                $user = Auth::user();
                $user_coin = $user_coin->where('id',$id)->whereHas('portfolio',function($query) use($user) {
                    $query->where('user_id',$user->id);
                })->first();
                if($user_coin == null) {
                    $validator->errors()->add("invalid_coin","Coin not found");
                }
            }
        });

        if($validator->passes()) {
            $user_coin = $user_coin->deleteUserCoin();
            return success($user_coin);
        }
        return fail(["errors"=>$validator->errors()]);
    }

    public function validateGetUserCoins(Request $request) {
        $validator = Validator::make($request->all(),[
            "portfolio_id"=>"integer"
        ]);

        return $validator;
    }

    public function validatePostUserCoins(Request $request) {
        $validator = Validator::make($request->all(),[
            "portfolio_id"=>"required|integer",
            "coin_id"=>"required|integer",
            "amount"=>"required|numeric",
            "entry_price"=>"required|numeric",
            "exit_price"=>"numeric|nullable"
        ]);

        $validator->after(function($validator) use($request) {
            if(count($validator->errors()->all()) < 1) {
                $user = Auth::user();
                $portfolio = Portfolio::where('id',$request->portfolio_id)->where('user_id',$user->id)->first();
                if(!$portfolio) {
                    $validator->errors()->add("invalid_portfolio","Portfolio not found");
                }
                $coin = Coin::find($request->coin_id);
                if(!$coin) {
                    $validator->errors()->add("invalid_coin","Coin not found");
                }
            }
        });

        return $validator;
    }

    public function validateUpdateUserCoin(Request $request) {
        $validator = Validator::make($request->all(),[
            "portfolio_id"=>"required|integer",
            "amount"=>"required|numeric",
            "entry_price"=>"required|numeric",
            "exit_price"=>"numeric|nullable"
        ]);

        return $validator;
    }

    public function validateDeletePortfolio(Request $request) {
        $validator = Validator::make($request->all(),[
        ]);

        return $validator;
    }
}
