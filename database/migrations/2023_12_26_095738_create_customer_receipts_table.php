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
        Schema::create('customer_receipts', function (Blueprint $table) {
            $table->id();
            $table->string("receipt_no")->unique();
            $table->unsignedBigInteger("customer");
            $table->foreign("customer")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
            $table->date("date");
            $table->integer("amount");
            $table->string("pay_mode");
            $table->string("reference_no")->nullable();
            $table->text("narration");
            $table->string("file_path");
            $table->string("file_name");
            $table->string("no");
            $table->integer("created_by");
            $table->integer("status")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_receipts');
    }
};
