<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReceiptProduct extends Model
{
    use HasFactory;
    protected  $table="customer_receipt_products";
    function invoice_id(){
        return $this->belongsTo(SaleInvoice::class,"invoice_id");
    }
}
