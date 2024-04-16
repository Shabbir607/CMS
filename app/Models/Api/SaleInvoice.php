<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;
    protected  $table="sale_invoices";
    function  location(){
        return $this->belongsTo(Location::class,"location");
    }
    function customer(){
        return $this->belongsTo(User::class,"customer");
    }
}
