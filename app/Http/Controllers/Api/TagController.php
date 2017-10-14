<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function getTags(Request $request) {
        $validator = $this->validateGetCoins($request);
        if($validator->passes()) {
            $coins = Tag::getCoins();
            return success($coins);
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
