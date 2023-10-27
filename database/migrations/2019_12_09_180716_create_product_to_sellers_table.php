<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductToSellersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_to_sellers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id')->index('seller_id_FK_idx');
			$table->integer('product_id')->index('product_id_FK_idx');
			$table->integer('product_quantity');
			$table->decimal('product_price', 10);
			$table->dateTime('product_date_available');
			$table->text('ship_to_countries', 65535)->nullable();
			$table->decimal('domastic_shipping', 10)->default(0.00);
			$table->decimal('international_shipping', 10)->default(0.00);
			$table->decimal('canada_shipping', 10)->default(0.00);
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
		Schema::drop('product_to_sellers');
	}

}
