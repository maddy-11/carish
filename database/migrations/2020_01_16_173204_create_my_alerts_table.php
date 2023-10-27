<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_alerts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('car_make')->nullable();
            $table->string('car_model')->nullable();
            $table->string('city')->nullable();
            $table->double('price_from')->nullable();
            $table->double('price_to')->nullable();
            $table->double('year_from')->nullable();
            $table->double('year_to')->nullable();
            $table->string('mileage_from')->nullable();
            $table->string('mileage_to')->nullable();
            $table->string('transmission')->nullable();
            $table->string('frequenct')->nullable();
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
        Schema::dropIfExists('my_alerts');
    }
}
