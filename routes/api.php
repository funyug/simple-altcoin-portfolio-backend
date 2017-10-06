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
    Route::post('/signup','UserController@postSignup');
    Route::post('/login','UserController@postLogin');

    Route::middleware("auth_api")->group(function() {
       Route::post('/portfolios','PortfolioController@storePortfolio');
       Route::get('/portfolios','PortfolioController@getPortfolios');
       Route::get('/portfolios/{id}','PortfolioController@getPortfolio');
       Route::put('/portfolios/{id}','PortfolioController@updatePortfolio');
       Route::delete('/portfolios/{id}','PortfolioController@deletePortfolio');

       Route::get('/user_coins','UserCoinController@getUserCoins');
       Route::post('/user_coins','UserCoinController@postUserCoins');
       Route::get('/user_coins/{id}','UserCoinController@getUserCoin');
       Route::put('/user_coins/{id}','UserCoinController@updateUserCoin');
       Route::delete('/user_coins/{id}','UserCoinController@deleteUserCoin');
    });
});