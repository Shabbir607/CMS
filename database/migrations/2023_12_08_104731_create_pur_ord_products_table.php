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
        Schema::create('pur_ord_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pur_ord_id")->nullable();
            $table->foreign("pur_ord_id")->references("id")->on("purchase_orders")->onDelete("cascade");
            $table->unsignedBigInteger("product")->nullable();
            $table->foreign("product")->references("id")->on("products")->onDelete("cascade");
            $table->integer("quantity")->nullable();
            $table->integer("rate")->nullable();
            $table->integer("amount")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pur_ord_products');
    }
};
