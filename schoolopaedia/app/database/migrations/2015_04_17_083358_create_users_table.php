<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usersdd', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('email', 60);
			$table->dateTime('email_updated_at');
			$table->string('password', 60);
			$table->string('password_temp', 60);
			$table->dateTime('password_updated_at');
			$table->string('code', 60);
			$table->boolean('active');
			$table->date('dob');
			$table->boolean('sex');
			$table->boolean('marriage_status');
			$table->string('relative_id', 30);
			$table->boolean('relation_with_person');
			$table->bigInteger('mobile_number');
			$table->boolean('mobile_verified');
			$table->dateTime('mobile_updated_at');
			$table->bigInteger('home_number');
			$table->string('add_1', 60);
			$table->string('add_2', 60);
			$table->string('city', 30);
			$table->string('state', 30);
			$table->string('country', 15);
			$table->string('pin_code', 10);
			$table->dateTime('address_updated_at');
			$table->string('pic', 100);
			$table->dateTime('pic_updated_at');
			$table->integer('permissions')->index('permissions');
			$table->integer('school_id')->index('school_id');
			$table->boolean('newsletter');
			$table->string('remember_token', 100);
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
		Schema::drop('users');
	}

}
