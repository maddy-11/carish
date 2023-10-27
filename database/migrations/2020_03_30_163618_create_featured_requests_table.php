<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ad_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('number_of_days')->nullable();
            $table->string('paid_amount')->nullable();
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
        Schema::dropIfExists('featured_requests');
    }
}
