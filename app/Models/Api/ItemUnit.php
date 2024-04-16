<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUnit extends Model
{
    use HasFactory;
    protected  $table='item_units';

    function product(){
        return $this->hasMany(Product::class);
    }
}
