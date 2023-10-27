<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponLinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon_lines', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('order_id')->index('order_idd_FK_idx');
			$table->integer('coupon_id')->index('coupon_id_FK_idx');
			$table->string('code', 100);
			$table->decimal('discount', 10);
			$table->string('discount_tax', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('coupon_lines');
	}

}
