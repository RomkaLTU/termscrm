<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obj_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->foreign('research_area_id')->references('id')->on('research_areas')->onDelete('cascade');
            $table->unsignedBigInteger('research_area_id');
            $table->foreign('object_id')->references('id')->on('objs')->onDelete('cascade');
            $table->unsignedBigInteger('object_id');
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->unsignedBigInteger('contract_id');
            $table->string('due_date')->nullable();
            $table->string('requiring_int')->nullable();
            $table->string('notes_1')->nullable();
            $table->string('notes_2')->nullable();
            $table->smallInteger('special_task')->default(0);
            $table->smallInteger('ecog')->default(0);
            $table->boolean('late')->default(0);
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
        Schema::dropIfExists('obj_tasks');
    }
}
