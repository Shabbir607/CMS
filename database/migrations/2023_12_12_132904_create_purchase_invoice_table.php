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
        Schema::create('purchase_invoice', function (Blueprint $table) {
            $table->id();
            $table->string("bill_no")->unique();
            $table->unsignedBigInteger("location");
            $table->foreign("location")->references("id")->on("locations")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("supplier");
            $table->foreign("supplier")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->date("invoice_date");
            $table->date("due_date");
            $table->string("invoice_no");
            $table->string("reference_no");
            $table->text("description");
            $table->integer("total_value");
            $table->integer("balance");
            $table->string("order_no")->nullable();
            $table->integer("created_by");
            $table->integer("status")->default(0);
            $table->integer("pay")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoice');
    }
};
