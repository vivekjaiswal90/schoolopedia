<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersLoginInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_login_info', function(Blueprint $table)
		{
			$table->foreign('user_id', 'users_login_info_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('school_id', 'users_login_info_ibfk_2')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_login_info', function(Blueprint $table)
		{
			$table->dropForeign('users_login_info_ibfk_1');
			$table->dropForeign('users_login_info_ibfk_2');
		});
	}

}
