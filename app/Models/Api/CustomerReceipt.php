<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReceipt extends Model
{
    use HasFactory;
    protected  $table="customer_receipts";
    function customer(){
        return $this->belongsTo(User::class,"customer");
    }
}
