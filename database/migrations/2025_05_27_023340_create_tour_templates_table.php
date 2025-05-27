<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tour_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_template_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_template_id')->constrained()->onDelete('cascade');
            $table->foreignId('object_item_id')->constrained()->onDelete('cascade');
            $table->integer('start_day');
            $table->integer('end_day');
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->decimal('cost_price', 12, 2);
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_template_mashruts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_template_id')->constrained()->onDelete('cascade');
            $table->foreignId('tour_city_id')->constrained()->onDelete('cascade');
            $table->integer('day_number');
            $table->string('program');
            $table->integer('order_no');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_template_mashruts');
        Schema::dropIfExists('tour_template_details');
        Schema::dropIfExists('tour_templates');
    }
};
