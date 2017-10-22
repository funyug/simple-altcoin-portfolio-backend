<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function() {
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Headers: Content-Type, *');
	
    Route::post('/signup','UserController@postSignup');
    Route::post('/login','UserController@postLogin');

    Route::middleware("auth_api")->group(function() {
       Route::post('/portfolios','PortfolioController@storePortfolio');
       Route::get('/portfolios','PortfolioController@getPortfolios');
       Route::get('/portfolios/{id}','PortfolioController@getPortfolio');
       Route::put('/portfolios/{id}','PortfolioController@updatePortfolio');
       Route::delete('/portfolios/{id}','PortfolioController@deletePortfolio');

       Route::get('/coins/{id}','CoinController@getCoin');
       Route::get('/coins/{id}/exchanges','CoinController@getExchanges');

       Route::get('/user_coins','UserCoinController@getUserCoins');
       Route::post('/user_coins','UserCoinController@postUserCoins');
       Route::get('/user_coins/{id}','UserCoinController@getUserCoin');
       Route::put('/user_coins/{id}','UserCoinController@updateUserCoin');
       Route::delete('/user_coins/{id}','UserCoinController@deleteUserCoin');

       Route::get('/exchanges','ExchangeController@getExchanges');
       Route::get('/exchanges/{id}','ExchangeController@getExchangeCoins');
    });
});