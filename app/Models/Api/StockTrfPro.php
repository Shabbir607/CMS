<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTrfPro extends Model
{
    use HasFactory;

    protected  $table="stock_transfer_pro";
    function product(){
        return $this->belongsTo(Product::class,"product_id");
    }
}
