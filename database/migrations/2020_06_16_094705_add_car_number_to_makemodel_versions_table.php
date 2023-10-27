<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarNumberToMakemodelVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('make_model_versions', function (Blueprint $table) {
            $table->string('car_number')->after('engin_power')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('make_model_versions', function (Blueprint $table) {
            $table->dropColumn('car_number');
        });
    }
}
