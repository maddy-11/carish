<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSparePartAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spare_part_ads', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('customer_id')->index('customer_id');
			$table->string('title', 191);
			$table->string('product_code', 191);
			$table->bigInteger('city_id')->unsigned()->index('city_id');
			$table->integer('category_id');
			$table->float('price');
			$table->integer('vat');
			$table->integer('neg');
			$table->string('condition', 191);
			$table->text('description');
			$table->string('poster_name', 191);
			$table->string('poster_email', 191);
			$table->string('poster_phone', 191);
			$table->integer('poster_city');
			$table->integer('status')->default(0);
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
		Schema::drop('spare_part_ads');
	}

}
