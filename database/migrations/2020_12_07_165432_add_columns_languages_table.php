<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages',function(Blueprint $table){
            $table->string('language_title',50)->after('language');
            $table->char('language_code',2)->after('language_title');
            $table->integer('sort_order')->default(0)->after('language_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages',function (Blueprint $table){
            $table->dropColumn('language_title');
            $table->dropColumn('language_code');
            $table->dropColumn('sort_order');
        });
        
    }
}
