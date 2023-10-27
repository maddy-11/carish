<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVersionModifyColumnTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('versions', function (Blueprint $table) {
            $table->renameColumn('fuel_type', 'fueltype');
            $table->renameColumn('fuel_average', 'average_fuel');
            $table->renameColumn('transmission_type', 'transmissiontype');
            $table->renameColumn('length', 'car_length');
            $table->renameColumn('width', 'car_width');
            $table->renameColumn('height', 'car_height');
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
