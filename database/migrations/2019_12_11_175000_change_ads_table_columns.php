<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAdsTableColumns extends Migration
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
            $table->dropColumn('bought_from'); 
            $table->renameColumn('year_id','year');
           // $table->string('year',4)->change();
            //$table->bigInteger('version_id')->nullable()->after('neg');
            //$table->text('features')->nullable()->after('description');
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
            $table->renameColumn('year', 'year_id');
            $table->bigInteger('year')->change();
            $table->dropColumn('version_id'); 
            $table->dropColumn('features'); 
         });
    }
}
