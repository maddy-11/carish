<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdSuggesstionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_suggesstion', function (Blueprint $table) {
            /*$table->bigIncrements('id');
            $table->timestamps();*/
            $table->unsignedBigInteger('ad_id');
            $table->unsignedBigInteger('suggesstion_id');
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            $table->foreign('suggesstion_id')->references('id')->on('suggesstions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_suggesstion');
    }
}
