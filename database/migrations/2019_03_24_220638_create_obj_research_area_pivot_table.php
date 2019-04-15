<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjResearchAreaPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obj_research_area', function (Blueprint $table) {
            $table->bigInteger('obj_id')->unsigned()->index();
            $table->foreign('obj_id')->references('id')->on('objs')->onDelete('cascade');
            $table->bigInteger('research_area_id')->unsigned()->index();
            $table->foreign('research_area_id')->references('id')->on('research_areas')->onDelete('cascade');
            $table->primary(['obj_id', 'research_area_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obj_research_area');
    }
}
