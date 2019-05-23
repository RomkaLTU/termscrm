<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParamGroupTaskParamPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('param_group_task_param', function (Blueprint $table) {
            $table->unsignedBigInteger('param_group_id')->index();
            $table->foreign('param_group_id')->references('id')->on('param_groups')->onDelete('cascade');
            $table->unsignedBigInteger('task_param_id')->index();
            $table->foreign('task_param_id')->references('id')->on('task_params')->onDelete('cascade');
            $table->primary(['param_group_id', 'task_param_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('param_group_task_param');
    }
}
