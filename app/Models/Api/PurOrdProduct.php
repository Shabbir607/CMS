<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurOrdProduct extends Model
{
    use HasFactory;
    protected  $table="pur_ord_products";


    function product(){
        return $this->belongsTo(Product::class,"product");
    }
}
