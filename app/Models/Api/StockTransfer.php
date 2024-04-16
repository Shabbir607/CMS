<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;

    protected  $table="stock_transfer";

    function source(){
        return $this->belongsTo(Location::class,"source");
    }
    function destination(){
        return $this->belongsTo(Location::class,"destination");
    }
    function product(){
        return $this->belongsTo(Product::class,"product_id");
    }
}
