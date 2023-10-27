<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('models', function(Blueprint $table)
		{
			$table->foreign('make_id', 'models_ibfk_1')->references('id')->on('makes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('make_id', 'models_ibfk_2')->references('id')->on('makes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('models', function(Blueprint $table)
		{
			$table->dropForeign('models_ibfk_1');
			$table->dropForeign('models_ibfk_2');
		});
	}

}
