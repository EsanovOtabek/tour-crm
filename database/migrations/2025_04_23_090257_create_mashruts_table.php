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
        Schema::create('mashruts', function (Blueprint $table) {
            $table->id(); // Mashrut ID
            $table->foreignId('tour_city_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->dateTime('date_time'); // Boriladigan vaqti
            $table->text('program')->nullable(); // Comment mashrut
            $table->integer('order_no')->default(1); // Tartibi
            $table->unique(['booking_id', 'order_no']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mashruts');
    }
};
