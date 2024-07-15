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
        Schema::create('training_histories_stok', function (Blueprint $table) {
            $table->id();
            $table->timestamp('training_time');
            $table->integer('start_year');
            $table->integer('end_year');
            $table->string('model_version', 50);
            $table->json('training_result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_histories_stok');
    }
};
