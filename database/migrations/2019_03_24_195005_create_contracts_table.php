<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contract_nr')->unique()->nullable();
            $table->string('customer')->nullable();
            $table->string('customer_address')->nullable();
            $table->enum('contract_status', ['galiojanti','sustabdyta','ivykdyta'])->default('galiojanti');
            $table->string('validity')->nullable();
            $table->boolean('validity_extended')->default(0);
            $table->date('validity_extend_till_value')->nullable();
            $table->date('validity_value')->nullable();
            $table->boolean('validity_verbal')->default(0);
            $table->double('contract_value',2)->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
