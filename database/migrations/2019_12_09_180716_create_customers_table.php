<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('customer_firstname', 200)->nullable();
			$table->string('customer_lastname', 200)->nullable();
			$table->string('customer_company')->nullable();
			$table->string('customer_vat')->nullable();
			$table->string('customer_registeration')->nullable();
			$table->char('customer_gender', 5)->default('Male');
			$table->dateTime('customers_dob')->nullable();
			$table->string('customer_email_address', 200);
			$table->text('customer_default_address', 65535)->nullable();
			$table->string('customers_telephone', 45);
			$table->string('customer_fax', 45)->nullable();
			$table->string('customer_password', 200);
			$table->char('customer_newsletter', 3)->nullable()->default('No');
			$table->text('remember_token', 65535)->nullable();
			$table->dateTime('password_reset_date')->nullable();
			$table->enum('customer_status', array('Active','Inactive'))->default('Active');
			$table->integer('country_id')->nullable();
			$table->bigInteger('citiy_id')->unsigned()->nullable()->index('citiy_id');
			$table->string('logo', 111)->nullable();
			$table->string('preferred_language', 30)->nullable();
			$table->string('customer_avatar')->nullable();
			$table->integer('language_id',10)->unsigned()->nullable()->index('language_id');
			$table->enum('customer_role', array('individual','business','subscriber'))->nullable()->default('individual');
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
		Schema::drop('customers');
	}

}
