<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_tag', function (Blueprint $table) {
           // DB::statement('SET FOREIGN_KEY_CHECKS=0'); 
            $table->unsignedBigInteger('ad_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('ad_id')->references('id')->on('ads');
            $table->foreign('tag_id')->references('id')->on('tags');
            //DB::statement('SET FOREIGN_KEY_CHECKS=1'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_tag');
    }
}
