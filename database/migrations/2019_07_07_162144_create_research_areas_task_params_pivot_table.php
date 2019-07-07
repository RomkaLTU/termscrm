<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchAreasTaskParamsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_area_task_param', function (Blueprint $table) {
            $table->bigInteger('research_area_id')->unsigned()->index();
            $table->foreign('research_area_id')->references('id')->on('research_areas')->onDelete('cascade');
            $table->bigInteger('task_param_id')->unsigned()->index();
            $table->foreign('task_param_id')->references('id')->on('task_params')->onDelete('cascade');
            $table->primary(['research_area_id', 'task_param_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_area_task_param');
    }
}
