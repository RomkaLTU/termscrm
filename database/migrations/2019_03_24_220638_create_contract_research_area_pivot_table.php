<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractResearchAreaPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_research_area', function (Blueprint $table) {
            $table->bigInteger('contract_id')->unsigned()->index();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->bigInteger('research_area_id')->unsigned()->index();
            $table->foreign('research_area_id')->references('id')->on('research_areas')->onDelete('cascade');
            $table->primary(['contract_id', 'research_area_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_research_area');
    }
}
