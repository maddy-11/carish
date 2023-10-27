<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('versions', function (Blueprint $table) {
            $table->string('length')->after('kilowatt')->nullable();
            $table->string('width')->after('length')->nullable();
            $table->string('height')->after('width')->nullable();
            $table->string('weight')->after('height')->nullable();
            $table->string('curb_weight')->after('weight')->nullable();
            $table->string('wheel_base')->after('curb_weight')->nullable();
            $table->string('ground_clearance')->after('wheel_base')->nullable();
            $table->string('seating_capacity')->after('ground_clearance')->nullable();
            $table->string('fuel_tank_capacity')->after('seating_capacity')->nullable();
            $table->string('number_of_door')->after('fuel_tank_capacity')->nullable();
            $table->string('displacement')->after('number_of_door')->nullable();
            $table->string('torque')->after('displacement')->nullable();
            $table->string('gears')->after('torque')->nullable();
            $table->string('max_speed')->after('gears')->nullable();
            $table->string('acceleration')->after('max_speed')->nullable();
            $table->string('number_of_cylinders')->after('acceleration')->nullable();
            $table->string('front_wheel_size')->after('number_of_cylinders')->nullable();
            $table->string('back_wheel_size')->after('front_wheel_size')->nullable();
            $table->string('front_tyre_size')->after('back_wheel_size')->nullable();
            $table->string('back_tyre_size')->after('front_tyre_size')->nullable();
            $table->string('drive_type')->after('back_tyre_size')->nullable();
            $table->string('fuel_type')->after('drive_type')->nullable();
            $table->string('fuel_average')->after('fuel_type')->nullable();
            $table->string('transmission_type')->after('fuel_average')->nullable(); 
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
            $table->dropColumn('length');
            $table->dropColumn('width');
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('curb_weight');
            $table->dropColumn('wheel_base');
            $table->dropColumn('ground_clearance');
            $table->dropColumn('seating_capacity');
            $table->dropColumn('fuel_tank_capacity');
            $table->dropColumn('number_of_door');
            $table->dropColumn('displacement');
            $table->dropColumn('torque');
            $table->dropColumn('gears');
            $table->dropColumn('acceleration');
            $table->dropColumn('number_of_cylinders');
            $table->dropColumn('front_wheel_size');
            $table->dropColumn('back_wheel_size');
            $table->dropColumn('front_tyre_size');
            $table->dropColumn('back_tyre_size');
            $table->dropColumn('drive_type');
            $table->dropColumn('fuel_type');
            $table->dropColumn('fuel_average');
            $table->dropColumn('transmission_type'); 
        });
    }
}
