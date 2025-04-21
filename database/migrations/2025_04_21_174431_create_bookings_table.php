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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tour_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['confirmed', 'cancelled','completed']);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_amount');
            $table->decimal('price');
            $table->decimal('cost_price');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
