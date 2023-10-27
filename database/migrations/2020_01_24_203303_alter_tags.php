<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('make_id')->unsigned()->nullable();
            $table->integer('model_id')->nullable();
            $table->integer('average_fuel')->nullable();
            $table->integer('mileage_total')->nullable();
            $table->integer('mileage_per_year')->nullable();
            $table->foreign('make_id')->references('id')->on('makes')->onDelete('set null');
            $table->foreign('model_id')->references('id')->on('models')->onDelete('set null');
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
            $table->dropColumn('make_id');
            $table->dropColumn('model_id');
            $table->dropColumn('average_fuel');
            $table->dropColumn('mileage_total');
            $table->dropColumn('mileage_per_year');
        });
    }
}
