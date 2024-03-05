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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable() // nullable for customer who don't want to log in to the system
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->uuid('transaction_code'); // should be uuid
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->dateTime('transaction_date');
            $table->string('qr_code_image'); // if customer want to scan all the tickets together
            $table->unsignedInteger('number_of_tickets')->comment('determine how many tickets the customer want to buy');
            $table->string('transaction_status'); // pending, success, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
