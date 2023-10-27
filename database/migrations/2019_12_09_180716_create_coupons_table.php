<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupons', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 45);
			$table->integer('product_id')->index('product_id_FK_idx');
			$table->dateTime('date_expired');
			$table->integer('usage_limit')->default(0);
			$table->integer('usage_count')->default(0);
			$table->string('email_restrictions', 45)->nullable();
			$table->string('individual_use', 45);
			$table->string('discount_type', 45)->nullable()->default('Fixed Price');
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
		Schema::drop('coupons');
	}

}
