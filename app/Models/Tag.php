<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function coins() {
        return $this->belongsToMany(Coin::class,'tag_coin','coin_id','tag_id')->wherePivot('user_id',Auth::user()->id);
    }
}
