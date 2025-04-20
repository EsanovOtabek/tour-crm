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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['green', 'yellow', 'red'])->default('yellow')->comment('green - tasdiqlangan, yellow - kutish, red - band');
            $table->foreignId('guide_category_id')->constrained('guide_categories')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->decimal('price', 15, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        // Creating pivot table for many-to-many relationship between guides and languages
        Schema::create('guide_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guide_id')->constrained('guides')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
