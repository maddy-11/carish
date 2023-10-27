<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeatureExpiryDateColumnToSparePartAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spare_part_ads', function (Blueprint $table) {
            $table->dateTime('feature_expiry_date')->after('poster_city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spare_part_ads', function (Blueprint $table) {
            $table->dropColumn('feature_expiry_date');
        });
    }
}
