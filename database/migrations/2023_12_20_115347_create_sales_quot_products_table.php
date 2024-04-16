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
        Schema::create('sales_quot_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sale_qout_id");
            $table->foreign("sale_qout_id")->references("id")->on("sales_quotations")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('sales_quot_products');
    }
};
