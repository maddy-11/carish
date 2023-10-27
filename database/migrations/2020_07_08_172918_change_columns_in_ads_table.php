<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsInAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('transmission_type');
            $table->dropColumn('fuel_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->enum('transmission_type', array('Manual','Automatic'))->nullable()->default('Manual');
            $table->enum('fuel_type', array('CNG','Diesel','Hybrid','LPG','Petrol'))->nullable()->default('Petrol');
        });
    }
}
