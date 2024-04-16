<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInvoicePay extends Model
{
    use HasFactory;
    protected  $table="supplier_invoice_pay";

    function  invoice(){
        return $this->belongsTo(PurchaseInvoice::class,"invoice_id");
    }
}
