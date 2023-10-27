<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPageDesciptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('page_desciption', function(Blueprint $table)
		{
			$table->foreign('page_id', 'page_desciption_ibfk_1')->references('id')->on('pages')->onUpdate('RESTRICT')->onDelete('CASCADE'); 
			$table->foreign('language_id', 'page_desciption_ibfk_2')->references('id')->on('languages')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('page_desciption', function(Blueprint $table)
		{
			$table->dropForeign('page_desciption_ibfk_1');
			$table->dropForeign('page_desciption_ibfk_2'); 
		});
	}

}
