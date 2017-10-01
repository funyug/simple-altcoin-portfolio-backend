<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->access_token) {
            $token = Token::getToken($request->access_token);
            if($token) {
                Auth::login($token->user);
                return $next($request);
            }
        }
        return fail(["errors"=>["invalid_token"=>"Invalid Token"]]);
    }
}
