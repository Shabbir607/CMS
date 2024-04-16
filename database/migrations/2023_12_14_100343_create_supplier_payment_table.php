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
        Schema::create('supplier_payment', function (Blueprint $table) {
            $table->id();
            $table->string("spay_no")->unique();
            $table->unsignedBigInteger("supplier");
            $table->foreign("supplier")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->date("date");
            $table->integer("amount");
            $table->string("pay_mode");
            $table->string("reference_no");
            $table->string("narration")->nullable();
            $table->string("file_name");
            $table->string("file_path");
            $table->string("pay_no");
            $table->integer("status")->default(0);
            $table->integer("created_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payment');
    }
};
