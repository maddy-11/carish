<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAdsTableCreateNewcolumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->bigInteger('bought_from_id')->after('country_id')->unsigned()->nullable();
            $table->foreign('bought_from_id')->references('id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->char('register_in_estonia', 7)->after('bought_from_id')->nullable();
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
            $table->dropForeign(['bought_from_id']);
            $table->dropColumn('bought_from_id');
            $table->dropColumn('register_in_estonia');
        });
    }
}
