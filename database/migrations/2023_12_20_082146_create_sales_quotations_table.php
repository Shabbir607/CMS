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
        Schema::create('sales_quotations', function (Blueprint $table) {
            $table->id();
            $table->string("sq");
            $table->unsignedBigInteger('location');
            $table->foreign("location")->references("id")->on("locations")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger("customer");
            $table->foreign("customer")->references("id")->on("users")->onDelete("cascade")->onDelete("cascade");
            $table->date("date");
            $table->date("expire_date");
            $table->integer("total_value");
            $table->string("reference_no")->nullable();
            $table->text("description");
            $table->text("terms_conditions")->nullable();
            $table->integer("status")->default(0);
            $table->string("sq_no");
            $table->integer("created_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_quotations');
    }
};
