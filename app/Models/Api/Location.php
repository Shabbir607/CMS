<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected  $table='locations';

    function stock_adjustment(){
        return $this->hasMany(StockAdjustment::class);
    }
    function stock_transfer(){
        return $this->hasMany(StockTransfer::class);
    }
    function product(){
        return $this->hasMany(Product::class);
    }
}
