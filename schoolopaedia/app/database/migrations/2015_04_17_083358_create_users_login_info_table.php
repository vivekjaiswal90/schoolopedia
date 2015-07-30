<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersLoginInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_login_info', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('user_id');
			$table->integer('school_id')->index('school_id');
			$table->string('ip', 30);
			$table->string('latitude', 10);
			$table->string('longitude', 10);
			$table->string('area_code', 10);
			$table->string('time_zone', 50);
			$table->string('country', 30);
			$table->string('isp', 30);
			$table->time('session_length');
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
		Schema::drop('users_login_info');
	}

}
