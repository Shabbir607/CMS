<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPay extends Model
{
    use HasFactory;
    protected  $table="supplier_payment";

    function  supplier ()
    {
        return $this->belongsTo(User::class,"supplier");
    }
}
