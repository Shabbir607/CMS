<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StAdjProduct extends Model
{
    use HasFactory;
    protected  $table ="st_adj_prod";

    function st_adj_id(){
        return $this->belongsTo(StockAdjustment::class,"st_adj_id");
    }

    function product_id(){
        return $this->belongsTo(Product::class,"product_id");
    }

}
