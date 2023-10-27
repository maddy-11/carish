<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id')->index('customer_id');
			$table->bigInteger('primary_service_id')->unsigned();
			$table->text('address_of_service', 65535)->nullable();
			$table->text('service_website')->nullable();
			$table->text('service_description', 65535)->nullable();
			$table->text('name_for_service')->nullable();
			$table->text('email_for_service')->nullable();
			$table->text('phone_of_service')->nullable();
			$table->enum('service_status', array('Active','Inactive'))->default('Inactive');
			$table->string('poster_name')->nullable();
			$table->string('poster_email')->nullable();
			$table->string('poster_phone')->nullable();
			 $table->enum('is_featured', ['true', 'false'])->default('false');
			$table->integer('status')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('services');
	}

}
