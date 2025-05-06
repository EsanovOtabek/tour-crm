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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('object_item_id')->constrained('object_items')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 12, 2);       // sale_price * quantity
            $table->decimal('cost_price', 12, 2);  // price * quantity
            $table->date('start_date');
            $table->date('end_date');


            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
