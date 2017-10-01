<?php

namespace App\Http\Controllers\Api;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    public function storePortfolio(Request $request) {
        $validator = $this->validateStorePortfolio($request);
        if($validator->passes()) {
            $portfolio = Portfolio::createPortfolio($request->name,$request->portfolio_id);
            return $portfolio;
        }
        return fail(["errors" => $validator->errors()]);
    }

    public function validateStorePortfolio(Request $request) {
        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "portfolio_id"=>"integer"
        ]);

        return $validator;
    }
}
