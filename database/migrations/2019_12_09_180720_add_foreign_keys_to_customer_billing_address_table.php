<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCustomerBillingAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_billing_address', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'customer_billing_address_ibfk_1')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customer_billing_address', function(Blueprint $table)
		{
			$table->dropForeign('customer_billing_address_ibfk_1');
		});
	}

}
