<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdsDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_description', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            DB::statement('SET FOREIGN_KEY_CHECKS=0'); 
            $table->bigIncrements('id');
            $table->integer('ad_id')->index('ad_id');
            $table->text('description', 65535)->nullable();
            $table->integer('language_id')->nullable()->index('language_id');
            $table->timestamps(); 

    DB::statement('SET FOREIGN_KEY_CHECKS=1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_description');
    }
}
