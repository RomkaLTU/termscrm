<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjTaskTaskParamPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obj_task_task_param', function (Blueprint $table) {
            $table->bigInteger('obj_task_id')->unsigned()->index();
            $table->foreign('obj_task_id')->references('id')->on('obj_tasks')->onDelete('cascade');
            $table->bigInteger('task_param_id')->unsigned()->index();
            $table->foreign('task_param_id')->references('id')->on('task_params')->onDelete('cascade');
            $table->primary(['obj_task_id', 'task_param_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obj_task_task_param');
    }
}
