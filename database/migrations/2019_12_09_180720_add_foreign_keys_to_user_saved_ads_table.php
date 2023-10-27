<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserSavedAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_saved_ads', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'user_saved_ads_ibfk_1')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('customer_id', 'user_saved_ads_ibfk_2')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('customer_id', 'user_saved_ads_ibfk_3')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ad_id', 'user_saved_ads_ibfk_4')->references('id')->on('ads')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_saved_ads', function(Blueprint $table)
		{
			$table->dropForeign('user_saved_ads_ibfk_1');
			$table->dropForeign('user_saved_ads_ibfk_2');
			$table->dropForeign('user_saved_ads_ibfk_3');
			$table->dropForeign('user_saved_ads_ibfk_4');
		});
	}

}
