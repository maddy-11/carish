<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiCodeColumnToBodyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('body_types', function (Blueprint $table) {
             $table->string('api_code')->after('name_slug')->nullable();
            $table->string('status')->after('api_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('body_types', function (Blueprint $table) {
            $table->dropColumn('api_code');
            $table->dropColumn('status');
        });
    }
}
