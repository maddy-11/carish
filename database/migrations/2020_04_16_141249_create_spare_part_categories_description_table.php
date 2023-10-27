<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparePartCategoriesDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_part_categories_description', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('spare_part_category_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('language_id')->nullable();
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
        Schema::dropIfExists('spare_part_categories_description');
    }
}
