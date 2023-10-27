<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersBasketAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers_basket_attributes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id')->index('customer_id');
			$table->integer('products_option_id');
			$table->integer('products_options_value_id');
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
		Schema::drop('customers_basket_attributes');
	}

}
