<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVersionAddSeriesGenerationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('versions', function (Blueprint $table) {
            $table->string('transmission_label')->after('label')->nullable();
            $table->decimal('engine_capacity', 8, 1)->after('extra_details')->default('0.00');
            $table->integer('engine_power')->after('engine_capacity')->default(0);
            $table->integer('id_car_serie')->after('engine_power')->default(0);
            $table->integer('id_car_generation')->after('id_car_serie')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('versions', function (Blueprint $table) {
            $table->dropColumn('transmission_label');
            $table->dropColumn('engine_capacity');
            $table->dropColumn('engine_power');
            $table->dropColumn('id_car_serie');
            $table->dropColumn('id_car_generation');
        });
    }
}
