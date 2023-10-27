<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVersionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('versions', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->text('name');
			$table->text('label');
			$table->integer('model_id')->index('model_id');
			$table->date('from_date')->nullable();
			$table->date('to_date')->nullable();
			$table->string('cc', 50)->nullable();
			$table->string('extra_details')->nullable();
			$table->integer('kilowatt')->nullable();
			$table->integer('sort_order')->default(0);
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
		Schema::drop('versions');
	}

}
