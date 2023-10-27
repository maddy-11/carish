<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('makes', function (Blueprint $table) {
             $table->string('year_begin')->after('status')->nullable();
             $table->string('year_end')->after('year_begin')->nullable();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('makes', function (Blueprint $table) {
            $table->dropColumn('year_begin');
            $table->dropColumn('year_end');
        });
       
    }
}
