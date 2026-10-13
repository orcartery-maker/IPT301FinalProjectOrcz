<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->foreignId('slot_id')->constrained()->restrictOnDelete();
            $table->string('booking_reference')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->enum('reservation_status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['cash', 'gcash', 'maya', 'bank_transfer'])->default('cash');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['slot_id', 'reservation_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
