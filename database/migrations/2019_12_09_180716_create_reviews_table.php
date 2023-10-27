<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reviews', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('form_id')->index('form_id');
			$table->integer('to_id')->index('to_id');
			$table->integer('review_rating');
			$table->string('review_title')->nullable();
			$table->text('review_description', 65535)->nullable();
			$table->enum('status', array('Active','Inactive'));
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
		Schema::drop('reviews');
	}

}
