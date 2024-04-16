<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected  $table="purchase_orders";


    function location(){
        return $this->belongsTo(Location::class,"location");
    }
    function supplier(){
        return $this->belongsTo(User::class,"supplier");
    }
}
