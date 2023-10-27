<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSavedAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_saved_ads', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('customer_id')->index('customer_id');
			$table->bigInteger('ad_id')->unsigned()->index('ad_id');
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
		Schema::drop('user_saved_ads');
	}

}
