<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_time_id')->constrained()->cascadeOnDelete();
            $table->date('slot_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['available', 'reserved'])->default('available');
            $table->timestamps();

            $table->unique(
                ['court_time_id', 'slot_date', 'start_time', 'end_time'],
                'slots_unique_time'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
