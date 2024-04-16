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
        Schema::create('st_adj_prod', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("st_adj_id")->nullable();
            $table->foreign('st_adj_id')->references("id")->on("stock_adjustments")->onDelete("cascade");
            $table->unsignedBigInteger('product_id')->nullable();;
            $table->foreign('product_id')->references("id")->on("products")->onDelete("cascade");
            $table->integer("adjust_qty")->nullable();;
            $table->integer("value")->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_adj_prod');
    }
};
