<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesDetail extends Model
{
    use HasFactory;
    protected $table="expenses_detail";


    function expenses_account(){
        return $this->belongsTo(ExpensesAccount::class,"expenses_account");
    }
}
