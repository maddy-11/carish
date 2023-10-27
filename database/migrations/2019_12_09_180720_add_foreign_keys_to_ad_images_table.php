<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAdImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ad_images', function(Blueprint $table)
		{
			$table->foreign('ad_id', 'ad_images_ibfk_1')->references('id')->on('ads')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ad_images', function(Blueprint $table)
		{
			$table->dropForeign('ad_images_ibfk_1');
		});
	}

}
