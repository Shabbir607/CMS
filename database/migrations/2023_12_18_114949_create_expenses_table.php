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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string("exp");
            $table->unsignedBigInteger("supplier");
            $table->foreign("supplier")->references('id')->on("users")->onUpdate("cascade")->onDelete("cascade");
            $table->string("pay_mode");
            $table->string("reference_no")->nullable();
            $table->date('date');
            $table->text('narration');
            $table->integer('total_amount');
            $table->string('file_path');
            $table->string('file_name');
            $table->string("exp_no");
            $table->integer("created_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
