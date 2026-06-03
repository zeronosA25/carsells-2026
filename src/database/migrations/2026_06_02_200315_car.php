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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->string('plate_number')->nullable();
            $table->string('color')->nullable();

            $table->enum('transmission', ['manual', 'automatic'])->default('manual');
            $table->string('fuel_type')->nullable();

            $table->integer('mileage')->default(0);
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);

            $table->enum('status', ['available', 'booked', 'sold'])->default('available');

            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
