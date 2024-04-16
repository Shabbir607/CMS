<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("expenses_id");
            $table->foreign("expenses_id")->references("id")->on("expenses")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("expenses_account");
            $table->foreign('expenses_account')->references('id')->on('expenses_account')->onDelete("cascade")->onUpdate("cascade");
            $table->text("description");
            $table->integer("amount");
            $table->unsignedBigInteger("location")->nullable();
            $table->foreign("location")->references("id")->on("locations")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses_detail');
    }
};
