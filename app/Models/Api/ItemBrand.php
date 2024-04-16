<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBrand extends Model
{
    use HasFactory;
    protected $table="item_brand";
    function product(){
        return $this->hasMany(Product::class);
    }
}
