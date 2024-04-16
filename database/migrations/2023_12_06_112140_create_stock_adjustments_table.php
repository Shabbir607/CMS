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
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger("location");
            $table->foreign("location")->references("id")->on("locations")->onDelete("cascade");
            $table->date('date');
            $table->string('remarks');
            $table->string('saj_no');
            $table->integer("total_value");
            $table->integer('created_by');
            $table->string("sjp_no");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
