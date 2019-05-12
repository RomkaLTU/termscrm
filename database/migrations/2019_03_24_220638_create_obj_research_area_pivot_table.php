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
            $table->unsignedBigInteger('obj_id')->index();
            $table->foreign('obj_id')->references('id')->on('objs')->onDelete('cascade');
            $table->unsignedBigInteger('research_area_id')->index();
            $table->foreign('research_area_id')->references('id')->on('research_areas')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
