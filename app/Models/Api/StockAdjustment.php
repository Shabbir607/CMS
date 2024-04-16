<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    use HasFactory;
    protected  $table='stock_adjustments';


    function location(){
        return $this->belongsTo(Location::class,"location");
    }

    function st_adj_id(){
        return $this->hasMany(StAdjProduct::class,);
    }

}
