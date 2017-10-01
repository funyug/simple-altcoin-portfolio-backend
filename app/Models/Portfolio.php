<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Portfolio extends Model
{
    public static function createPortfolio($name,$portfolio_id) {
        $portfolio = new Portfolio();
        $portfolio->name = $name;
        $portfolio->user_id = Auth::user()->id;
        $portfolio->portfolio_id = $portfolio_id;
        $portfolio->save();
        return $portfolio;
    }
}
