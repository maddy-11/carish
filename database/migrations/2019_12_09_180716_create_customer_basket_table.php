<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerBasketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_basket', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id')->index('customer_id_FK_idx');
			$table->integer('product_id');
			$table->integer('basket_quantity');
			$table->decimal('final_price', 10);
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
		Schema::drop('customer_basket');
	}

}
