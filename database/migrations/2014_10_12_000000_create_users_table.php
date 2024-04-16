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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();;
            $table->string('display_name')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('shipping_address')->nullable();
            $table->integer("active")->nullable();
            $table->integer("tax_registered")->nullable();
            $table->string('tax_no')->nullable();
            $table->string('currency')->nullable();
            $table->string("date_of_balance")->nullable();
            $table->integer('balance')->nullable();
            $table->string('balance_type')->nullable();
            $table->string('payment_terms')->nullable();
            $table->integer('credit_limit')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('remarks')->nullable();
            $table->integer("status")->default(1);
            $table->string('type');
            $table->string("role")->nullable();
            $table->integer('created_by');
            $table->string('action')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
