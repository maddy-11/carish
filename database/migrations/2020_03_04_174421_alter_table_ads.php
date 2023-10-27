<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private function registerEnumWithDoctrine()
    {
        DB::getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');
    }
    
    public function up()
    {
        $this->registerEnumWithDoctrine();
        Schema::table('ads', function (Blueprint $table) {
            $table->integer('status')->comment('0=pending , 1=active , 2=removed , 3=not-approved')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->registerEnumWithDoctrine();
        Schema::table('ads', function (Blueprint $table) {
            $table->integer('status')->default(0);
            
        });
    }
}
