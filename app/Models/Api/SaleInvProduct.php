<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvProduct extends Model
{
    use HasFactory;
    protected  $table="sale_inv_products";

    function product(){
        return $this->belongsTo(Product::class,"product");
    }
}
