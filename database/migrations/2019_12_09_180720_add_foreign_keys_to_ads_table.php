<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ads', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'ads_ibfk_1')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('customer_id', 'ads_ibfk_2')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('maker_id', 'ads_ibfk_4')->references('id')->on('makes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('model_id', 'ads_ibfk_5')->references('id')->on('models')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('color_id', 'ads_ibfk_7')->references('id')->on('colors')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('city_id', 'ads_ibfk_8')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ads', function(Blueprint $table)
		{
			$table->dropForeign('ads_ibfk_1');
			$table->dropForeign('ads_ibfk_2');
			$table->dropForeign('ads_ibfk_4');
			$table->dropForeign('ads_ibfk_5');
			$table->dropForeign('ads_ibfk_7');
			$table->dropForeign('ads_ibfk_8');
		});
	}

}
