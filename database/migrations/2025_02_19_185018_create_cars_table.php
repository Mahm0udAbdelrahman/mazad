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
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('car_type_id')->constrained('car_types','id')->cascadeOnDelete();
            $table->string('name');
            $table->string('model');
            $table->string('color');
            $table->string('kilometer');
            $table->string('price');
            $table->text('description');
            $table->string('video');
            $table->string('license_year');
            $table->string('image_license');
            $table->string('report');
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->boolean('deposit')->default(0);
            $table->boolean('sold')->default(0);
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
