<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAdFeaturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ad_features', function(Blueprint $table)
		{
			$table->foreign('ad_id', 'ad_features_ibfk_1')->references('id')->on('ads')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('features_id', 'ad_features_ibfk_2')->references('id')->on('features')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ad_features', function(Blueprint $table)
		{
			$table->dropForeign('ad_features_ibfk_1');
			$table->dropForeign('ad_features_ibfk_2');
		});
	}

}
