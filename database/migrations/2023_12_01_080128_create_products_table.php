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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->string('barcode');
            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on("item_category")->onDelete('cascade');
            $table->unsignedBigInteger('type');
            $table->foreign('type')->references('id')->on('item_type')->onDelete('cascade');
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('item_brand')->onDelete('cascade');
            $table->integer('quantity');
            $table->unsignedBigInteger('packing_unit');
            $table->foreign('packing_unit')->references('id')->on('item_units')->onDelete('cascade');
            $table->unsignedBigInteger('inventory_unit');
            $table->foreign('inventory_unit')->references('id')->on("item_units")->onDelete('cascade');
            $table->integer('unit_conversion');
            $table->integer('opening_stock');
            $table->date('opening_date');
            $table->unsignedBigInteger('location');
            $table->foreign('location')->references('id')->on('locations')->onDelete('cascade');
            $table->string('color');
            $table->string('size');
            $table->unsignedBigInteger('supplier');
            $table->foreign('supplier')->references('id')->on("users")->onDelete('cascade');
            $table->integer('selling_price');
            $table->integer('purchase_price');
            $table->string('tax');
            $table->text('description');
            $table->text('image');
            $table->integer('created_by');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
