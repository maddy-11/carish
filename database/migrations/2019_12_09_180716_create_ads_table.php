<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ads', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('customer_id')->nullable()->index('customer_id');
			$table->bigInteger('city_id')->unsigned()->nullable()->index('city_id');
			$table->bigInteger('maker_id')->unsigned()->nullable()->index('maker_id');
			$table->integer('model_id')->nullable()->index('model_id');
			$table->date('year_id')->nullable();
			$table->bigInteger('color_id')->unsigned()->nullable()->index('color_id');
			$table->string('bought_from', 191)->nullable();
			$table->integer('millage')->nullable();
			$table->string('fuel_average', 191);
			$table->float('price');
			$table->integer('vat');
			$table->integer('neg');
			$table->text('description');
			$table->string('engine_capacity', 100)->nullable();
			$table->string('engine_power', 100)->nullable();
			$table->enum('fuel_type', array('CNG','Diesel','Hybrid','LPG','Petrol'))->nullable()->default('Petrol');
			$table->enum('transmission_type', array('Manual','Automatic'))->nullable()->default('Manual');
			$table->enum('assembly', array('Local','Imported'))->nullable();
			$table->string('poster_name', 191);
			$table->string('poster_email', 191);
			$table->string('poster_phone', 191);
			$table->integer('poster_city');
			$table->integer('status')->default(0);
			$table->timestamps();
			$table->integer('views')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ads');
	}

}
