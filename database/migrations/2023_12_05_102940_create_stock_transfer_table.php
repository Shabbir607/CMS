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
        Schema::create('stock_transfer', function (Blueprint $table) {
            $table->id();
            $table->string("st_no")->unique();
            $table->unsignedBigInteger('source');
            $table->foreign('source')->references('id')->on("locations")->onDelete('cascade');
            $table->unsignedBigInteger('destination');
            $table->foreign('destination')->references('id')->on("locations")->onDelete("cascade");
            $table->date("date");
            $table->text("narration");
            $table->text("file");
            $table->integer("total");
            $table->string("stp_no");
            $table->integer("created_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfer');
    }
};
