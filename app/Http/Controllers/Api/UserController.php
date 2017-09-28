<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request) {
        if($this->validateLogin($request)) {
            $user = Auth::user();
            $access_token = $user->createToken($request->device_id);
            $data = ["access_token"=>$access_token];
            return success($data);
        }
    }

    public function signup(Request $request) {
        if($this->validateSignup($request)) {
            return $this->login($request);
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
        $user = User::where('email',$request->email)->first();
        if($user) {
            if(Hash::check($request->password,$user->password)) {
                Auth::login($user);
                return true;
            }
        }

        $validator->errors()->add("incorrect_login","Username or password is incorrect");

        return response($validator->errors()->all());
    }

    public function validateSignup(Request $request) {
        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "email"=>"required|email",
            "password"=>"required|min:6|max:32"
        ]);

        if($validator->fails()) {
            return response($validator->errors()->all());
        }
        $user = User::where('email',$request->email)->first();
        if(!$user) {
            User::createUser($request);
            return true;
        }
        $validator->errors()->add("email_exists","Email already exists");
        return response($validator->errors()->all());

    }
}
