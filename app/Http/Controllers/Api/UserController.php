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
    public function postLogin(Request $request) {
        $validator = $this->validateLogin($request);
        if(!$validator->fails()) {
            $user = Auth::user();
            $access_token = $user->createToken($request->device_id);
            $data = ["access_token"=>$access_token];
            return success($data);
        }
        return fail(["errors" => $validator->errors()]);
    }

    public function postSignup(Request $request) {
        $validator = $this->validateSignup($request);
        if(!$validator->fails()) {
            return $this->postLogin($request);
        }
        else {
            return fail(["errors" => $validator->errors()]);
        }
    }

    public function validateLogin(Request $request) {
        $validator = Validator::make($request->all(),[
           "email"=>"required",
           "password"=>"required",
            "device_id"=>"required"
        ]);

        $validator->after(function ($validator) use($request) {
            if(count($validator->errors()->all()) < 1) {
                $user = User::where('email',$request->email)->first();
                if($user && Hash::check($request->password,$user->password)) {
                    Auth::login($user);
                }
                else {
                    $validator->errors()->add("incorrect_login","Username or password is incorrect");
                }
            }
        });

        return $validator;
    }

    public function validateSignup(Request $request) {
        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "email"=>"required|email",
            "password"=>"required|min:6|max:32",
            "device_id"=>"required"
        ]);

        $validator->after(function ($validator) use($request) {
            if(count($validator->errors()->all()) < 1) {
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    User::createUser($request);
                } else {
                    $validator->errors()->add("email_exists", "Email already exists");
                }
            }
        });
        return $validator;
    }
}
