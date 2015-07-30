<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersRegisteredToSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_registered_to_session', function(Blueprint $table)
		{
			$table->foreign('school_session_id', 'users_registered_to_session_ibfk_1')->references('id')->on('school_session')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('school_id', 'users_registered_to_session_ibfk_2')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'users_registered_to_session_ibfk_3')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_registered_to_session', function(Blueprint $table)
		{
			$table->dropForeign('users_registered_to_session_ibfk_1');
			$table->dropForeign('users_registered_to_session_ibfk_2');
			$table->dropForeign('users_registered_to_session_ibfk_3');
		});
	}

}
