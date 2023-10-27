<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProductToSellersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_to_sellers', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'product_to_sellers_ibfk_1')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_to_sellers', function(Blueprint $table)
		{
			$table->dropForeign('product_to_sellers_ibfk_1');
		});
	}

}
