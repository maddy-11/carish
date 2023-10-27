<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_questions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('product_id', 45);
			$table->integer('customer_id')->index('customer_id');
			$table->string('question_title');
			$table->text('question_description', 65535)->nullable();
			$table->enum('question_status', array('Active','Inactive'))->default('Active');
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
		Schema::drop('product_questions');
	}

}
