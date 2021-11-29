<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->string('name',191);
            $table->string('slug',191);
            $table->string('trainer_name',191)->nullable();
            $table->string('pretest_link',191)->nullable();
            $table->string('posttest_link',191)->nullable();
            $table->text('task_desc')->nullable();
            $table->dateTime('start_date',0);
            $table->dateTime('end_date',0);
            $table->string('status',1);
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
        Schema::dropIfExists('trainings');
    }
}
