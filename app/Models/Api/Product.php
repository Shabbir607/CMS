<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    function stock_transfer(){
        return $this->hasMany(StockTransfer::class);
    }

    function packing_unit(){
        return $this->belongsTo(ItemUnit::class,"packing_unit");
    }
    function inventory_unit(){
        return $this->belongsTo(ItemUnit::class,"inventory_unit");
    }
    function category(){
        return $this->belongsTo(ItemCategory::class,"category");
    }
    function type(){
        return $this->belongsTo(ItemType::class,"type");

    }
    function brand(){
        return $this->belongsTo(ItemBrand::class,"brand");
    }
     function supplier(){
        return $this->belongsTo(User::class,"supplier");
     }
     function location(){
        return $this->belongsTo(Location::class,"location");
     }
     function st_adj_pro(){
        return $this->hasMany(StAdjProduct::class);
     }
}
