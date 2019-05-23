<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjTaskParamGroupPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obj_task_param_group', function (Blueprint $table) {
            $table->unsignedBigInteger('obj_task_id')->index();
            $table->foreign('obj_task_id')->references('id')->on('obj_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('param_group_id')->index();
            $table->foreign('param_group_id')->references('id')->on('param_groups')->onDelete('cascade');
            $table->primary(['obj_task_id', 'param_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obj_task_param_group');
    }
}
