<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersRegisteredToSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_registered_to_session', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('school_session_id')->index('school_session_id');
			$table->integer('school_id')->index('school_id');
			$table->integer('user_id')->index('user_id');
			$table->integer('user_type');
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
		Schema::drop('users_registered_to_session');
	}

}
