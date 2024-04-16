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
        Schema::create('supplier_invoice_pay', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("supplier_pay_id")->nullable();
            $table->foreign("supplier_pay_id")->references("id")->on("supplier_payment")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("invoice_id")->nullable();;
            $table->foreign("invoice_id")->references("id")->on("purchase_invoice")->onDelete('cascade')->onUpdate("cascade");
            $table->integer("paying")->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoice_pay');
    }
};
