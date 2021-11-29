<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiuserTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diuser_training', function (Blueprint $table) {
            $table->foreignId('diuser_id');
            $table->foreignId('training_id')->constrained('trainings');
            $table->bigInteger('pretest')->nullable();
            $table->bigInteger('posttest')->nullable();
            $table->boolean('final_value')->nullable();
            $table->primary(['diuser_id','training_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diuser_training');
    }
}
