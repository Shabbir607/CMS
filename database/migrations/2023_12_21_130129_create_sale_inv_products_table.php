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
        Schema::create('sale_inv_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sale_inv_id");
            $table->foreign("sale_inv_id")->references("id")->on("sale_invoices")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger("product");
            $table->foreign("product")->references("id")->on("products")->onUpdate("cascade")->onDelete("cascade");
            $table->integer("quantity");
            $table->integer("rate");
            $table->integer("amount");
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_inv_products');
    }
};
