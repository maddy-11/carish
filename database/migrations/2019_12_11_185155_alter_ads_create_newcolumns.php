<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAdsCreateNewcolumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    Schema::table('ads', function (Blueprint $table) {
       $table->string('year',4)->change();
       $table->bigInteger('version_id')->nullable()->after('neg');
       $table->text('features')->nullable()->after('description');
       $table->dropColumn('engine_capacity'); 
       $table->dropColumn('engine_power'); 
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
       $table->bigInteger('year')->change();
       $table->dropColumn('version_id'); 
       $table->dropColumn('features'); 
   });
    }
}
