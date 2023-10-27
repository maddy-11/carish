<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnGeneralGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->integer('perpage_ads')->default(50)->after('spare_parts_limit');
            $table->integer('perpage_spareparts')->default(50)->after('perpage_ads');
            $table->integer('perpage_services')->default(50)->after('perpage_spareparts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         $table->dropColumn('perpage_ads');
         $table->dropColumn('perpage_spareparts');
         $table->dropColumn('perpage_services');
    }
}
