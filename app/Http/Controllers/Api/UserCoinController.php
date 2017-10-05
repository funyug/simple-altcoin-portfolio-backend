<?php

namespace App\Http\Controllers\Api;

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
            $user_coins = UserCoin::getCoins($request->portfolio_id,$user->id);
            return success($user_coins);
        }
        return fail(["errors" => $validator->errors()]);
    }

    public function validateGetUserCoins(Request $request) {
        $validator = Validator::make($request->all(),[
            "portfolio_id"=>"integer"
        ]);

        return $validator;
    }
}
