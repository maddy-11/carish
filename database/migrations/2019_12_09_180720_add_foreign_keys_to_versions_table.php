<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVersionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('versions', function(Blueprint $table)
		{
			$table->foreign('model_id', 'versions_ibfk_1')->references('id')->on('models')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('model_id', 'versions_ibfk_2')->references('id')->on('models')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('versions', function(Blueprint $table)
		{
			$table->dropForeign('versions_ibfk_1');
			$table->dropForeign('versions_ibfk_2');
		});
	}

}
