<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSparePartAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('spare_part_ads', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'spare_part_ads_ibfk_1')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('customer_id', 'spare_part_ads_ibfk_2')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('city_id', 'spare_part_ads_ibfk_3')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('spare_part_ads', function(Blueprint $table)
		{
			$table->dropForeign('spare_part_ads_ibfk_1');
			$table->dropForeign('spare_part_ads_ibfk_2');
			$table->dropForeign('spare_part_ads_ibfk_3');
		});
	}

}
