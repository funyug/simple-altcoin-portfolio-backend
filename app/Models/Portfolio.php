<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Portfolio extends Model
{
    public $guarded = ['id'];
    public static function createPortfolio($name,$portfolio_id) {
        $portfolio = new Portfolio();
        $portfolio->name = $name;
        $portfolio->user_id = Auth::user()->id;
        $portfolio->portfolio_id = $portfolio_id;
        $portfolio->save();
        return $portfolio;
    }

    public static function getPortfolios($user_id,$portfolio_id) {
        $portfolios = new Portfolio();
        if($user_id) {
            $portfolios = $portfolios->where("user_id",$user_id);
        }
        if($portfolio_id) {
            $portfolios = $portfolio_id->where("portfolio_id",$portfolio_id);
        }
        $portfolios = $portfolios->get();
        return $portfolios;
    }

    public static function getPortfolio($user_id,$portfolio_id) {
        $portfolio = Portfolio::where("user_id",$user_id)->where('id',$portfolio_id)->first();
        return $portfolio;
    }

    public function updatePortfolio($name,$portfolio_id) {
        $this->update(["name"=>$name,"portfolio_id"=>$portfolio_id]);
        return $this;
    }
}
