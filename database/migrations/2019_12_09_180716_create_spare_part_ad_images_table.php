<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSparePartAdImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spare_part_ad_images', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('spare_part_ad_id');
			$table->string('img', 191);
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
		Schema::drop('spare_part_ad_images');
	}

}
