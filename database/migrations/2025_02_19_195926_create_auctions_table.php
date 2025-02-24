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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('car_id')->constrained('cars','id')->cascadeOnDelete();
            $table->string('start_price');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->foreignId('winner_id')->nullable()->constrained('users','id')->cascadeOnDelete();
            $table->string('winner_price')->nullable();
            $table->string('winner_date')->nullable();
            $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
           $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
