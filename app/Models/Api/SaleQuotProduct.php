<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleQuotProduct extends Model
{
    use HasFactory;
    protected $table="sales_quot_products";

    function product(){
        return $this->belongsTo(Product::class,"product");
    }
}
