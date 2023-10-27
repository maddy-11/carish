<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTimingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_timings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id');
			$table->enum('day_name', ['All days', 'Monday to Friday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])->nullable();
			$table->time('opening_time');
			$table->time('closing_time');
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
		Schema::drop('customer_timings');
	}

}
