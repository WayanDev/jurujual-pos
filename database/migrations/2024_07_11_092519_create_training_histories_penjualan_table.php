<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingHistoriesPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_histories_penjualan', function (Blueprint $table) {
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_histories_penjualan');
    }
}
