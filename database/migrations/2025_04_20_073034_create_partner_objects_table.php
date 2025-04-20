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
        Schema::create('partner_objects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Obyektning nomi (Hotel, Restoran)
            $table->float('rating')->nullable(); // Reytingi
            $table->foreignId('partner_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('location')->nullable(); // Joylashuvi
            $table->decimal('latitude', 10, 8)->nullable(); // x kordinata
            $table->decimal('longitude', 11, 8)->nullable(); // y kordinata
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_objects');
    }
};
