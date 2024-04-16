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
        Schema::create('pur_invoice_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pur_invoice_id");
            $table->foreign("pur_invoice_id")->references("id")->on("purchase_invoice")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("product");
            $table->foreign("product")->references("id")->on("products")->onDelete("cascade")->onUpdate("cascade");
            $table->integer("quantity");
            $table->integer("rate");
            $table->integer("amount");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pur_invoice_product');
    }
};
