<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request) {
        if($this->validateLogin($request)) {

        }
    }

    public function validateLogin(Request $request) {
        $validator = Validator::make($request->all(),[
           "email"=>"required",
           "password"=>"required"
        ]);

        if($validator->fails()) {
            return response($validator->errors()->all());
        }
        return true;
    }
}
