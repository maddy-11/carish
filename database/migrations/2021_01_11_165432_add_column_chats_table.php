<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chats',function(Blueprint $table){
            $table->integer('ad_id')->default(0)->after('archived_status');
            $table->string('type',50)->nullable()->after('ad_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chats',function (Blueprint $table){
            $table->dropColumn('ad_id');
            $table->dropColumn('type');
        });
        
    }
}
