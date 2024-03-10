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
        Schema::create('transaction_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')
                ->constrained('transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->uuid('transaction_code'); // should be uuid
            // same like `tickets` table, why? for snapshots
            $table->string('name');
            $table->string('ticket_code');
            $table->decimal('price', 15, 5);
            $table->string('group'); // kid, adult, senior, etc
            $table->string('qr_code_image'); // if customer want to scan the ticket
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_tickets');
    }
};
