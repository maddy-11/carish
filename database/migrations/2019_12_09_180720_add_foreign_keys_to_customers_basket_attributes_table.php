<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCustomersBasketAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customers_basket_attributes', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'customers_basket_attributes_ibfk_1')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('customer_id', 'customers_basket_attributes_ibfk_2')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('customer_id', 'customers_basket_attributes_ibfk_3')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customers_basket_attributes', function(Blueprint $table)
		{
			$table->dropForeign('customers_basket_attributes_ibfk_1');
			$table->dropForeign('customers_basket_attributes_ibfk_2');
			$table->dropForeign('customers_basket_attributes_ibfk_3');
		});
	}

}
