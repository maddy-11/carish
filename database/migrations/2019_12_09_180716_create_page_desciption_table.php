<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageDesciptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_desciption', function(Blueprint $table)
		{
			$table->integer('page_id')->index('page_id');
			$table->string('title');
			$table->text('description', 65535)->nullable();
			$table->integer('language_id',10)->unsigned()->nullable()->index('language_id');
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
		Schema::drop('page_desciption');
	}

}
