<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractObjPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_obj', function (Blueprint $table) {
            $table->bigInteger('obj_id')->unsigned()->index();
            $table->foreign('obj_id')->references('id')->on('objs')->onDelete('cascade');
            $table->bigInteger('contract_id')->unsigned()->index();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->primary(['obj_id', 'contract_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_obj');
    }
}
