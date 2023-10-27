<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_products', function(Blueprint $table)
		{
			$table->integer('id');
			$table->integer('order_id')->index('order_id_FK_idx');
			$table->decimal('product_price', 10);
			$table->string('product_name', 45);
			$table->text('product_description', 65535);
			$table->string('product_model', 45)->nullable();
			$table->string('product_quantity', 45)->nullable();
			$table->enum('product_status', array('Pending','Shipped','Cancelled','Refunded'))->default('Pending');
			$table->string('products_tax', 45)->nullable();
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
		Schema::drop('order_products');
	}

}
