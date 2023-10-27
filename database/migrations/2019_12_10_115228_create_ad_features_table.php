<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdFeaturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ad_features', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->bigInteger('ad_id')->unsigned()->nullable()->index('ad_id');
			$table->integer('features_id')->nullable()->index('feature_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ad_features');
	}

}
