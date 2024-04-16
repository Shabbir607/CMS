<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_receipt_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("receipt_id");
            $table->foreign("receipt_id")->references("id")->on("customer_receipts")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger("invoice_id");
            $table->foreign("invoice_id")->references("id")->on("sale_invoices")->onUpdate("cascade")->onDelete("cascade");
            $table->integer("pay");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_receipt_products');
    }
};
