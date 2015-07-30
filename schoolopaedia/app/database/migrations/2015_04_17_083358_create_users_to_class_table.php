<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersToClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_to_class', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('session_id')->index('session_id');
			$table->integer('stream_id')->index('stream_id');
			$table->integer('section_id')->index('section_id');
			$table->integer('class_id')->index('class_id');
			$table->integer('user_id')->index('user_id');
			$table->dateTime('deleted_at');
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
		Schema::drop('users_to_class');
	}

}
