<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreataAdsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_status_histories', function(Blueprint $table)
        {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('user_id')->nullable();
            $table->integer('ad_id')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('new_status')->nullable();
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
        Schema::drop('ads_status_histories');
    }
}
