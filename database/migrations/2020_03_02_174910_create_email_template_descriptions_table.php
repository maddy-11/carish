<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailTemplateDescriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_template_descriptions', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('email_template_id')->index('email_template_id');
			$table->integer('language_id')->nullable()->index('language_id');
			$table->string('type', 191);
			$table->string('subject', 191);
			$table->binary('content', 65535);
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
		Schema::drop('email_template_descriptions');
	}

}
