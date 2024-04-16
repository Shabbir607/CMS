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
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->string("inv_no")->unique();
            $table->unsignedBigInteger("location");
            $table->foreign("location")->references("id")->on("locations")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger("customer");
            $table->foreign("customer")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
            $table->date("invoice_date");
            $table->date("due_date");
            $table->string("reference_no")->nullable();
            $table->text("description");
            $table->text("terms_condition")->nullable();
            $table->integer("total_value");
            $table->integer("balance");
            $table->integer("pay")->default(0);
            $table->integer("status")->default(0);
            $table->string("sale_no")->nullable();
            $table->integer("created_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_invoices');
    }
};
