<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services',function(Blueprint $table){
            $table->integer('sub_service_id')->default(0)->after('primary_service_id');
            $table->integer('sub_sub_service_id')->default(0)->after('sub_service_id');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services',function (Blueprint $table){
            $table->dropColumn('sub_service_id');
            $table->dropColumn('sub_sub_service_id');
        });
        
    }
}
