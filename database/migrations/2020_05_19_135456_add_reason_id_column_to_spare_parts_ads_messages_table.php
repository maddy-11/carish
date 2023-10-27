<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonIdColumnToSparePartsAdsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spare_parts_ads_messages', function (Blueprint $table) {
            $table->string('reason_id')->after('spare_parts_ads_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spare_parts_ads_messages', function (Blueprint $table) {
            $table->dropColumn('reason_id');
        });
    }
}
