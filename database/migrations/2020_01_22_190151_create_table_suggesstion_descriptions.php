<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSuggesstionDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggesstion_descriptions', function (Blueprint $table) {
            $table->integer('suggesstion_id')->index('suggesstion_id');
            $table->string('title');
            $table->text('sentence', 65535)->nullable();
            $table->integer('language_id')->nullable()->index('language_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suggesstion_descriptions');
    }
}
