<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSuggesstionDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suggesstion_descriptions', function (Blueprint $table) {
            $table->bigInteger('id', true)->first()->unsigned();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suggesstion_descriptions', function (Blueprint $table) {
            $table->dropColumn('id');
            
        });
    }
}
