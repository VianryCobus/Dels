<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_training', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('training_id')->constrained('trainings');
            $table->foreignId('training_id')->nullable();
            $table->string('task');
            $table->string('slug',191);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_training');
    }
}
