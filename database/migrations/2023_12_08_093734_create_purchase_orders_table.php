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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
             $table->string("po_no")->unique();
             $table->unsignedBigInteger("location");
             $table->foreign("location")->references("id")->on("locations")->onDelete("cascade");
             $table->unsignedBigInteger("supplier");
             $table->foreign("supplier")->references("id")->on("users")->onDelete("cascade");
             $table->date("order_date");
              $table->date("expected_date");
              $table->string("reference_no");
              $table->text("description");
              $table->text("terms_and_conditions")->nullable();
              $table->integer("total_value");
              $table->integer("created_by");
              $table->integer("status")->default(0);
            $table->string("order_no");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
