<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeneralSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('general_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('default_language');
			$table->string('phone_number')->nullable();
			$table->string('status')->nullable();
			$table->string('logo')->nullable();
			$table->string('small_logo')->nullable();
			$table->string('favicon')->nullable();
			$table->string('title')->nullable();
			$table->string('business_email')->nullable();
			$table->string('complaint_email')->nullable();
			$table->text('address', 65535)->nullable();
			$table->string('fax')->nullable();
			$table->text('other_info', 65535)->nullable();
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
		Schema::drop('general_settings');
	}

}
