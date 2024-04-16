<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurIncProduct extends Model
{
    use HasFactory;

    protected $table = "pur_invoice_product";
    function  product(){
        return $this->belongsTo(Product::class,"product");
    }
}
