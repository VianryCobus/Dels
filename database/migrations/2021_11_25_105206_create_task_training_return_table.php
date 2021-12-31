<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTrainingReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_training_return', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('task_id')->constrained('task_training');
            $table->foreignId('task_id')->nullable();
            $table->foreignId('diuser_id')->nullable();
            $table->string('return_task');
            $table->string('slug',191);
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
        Schema::dropIfExists('task_training_return');
    }
}
