<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersToClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_to_class', function(Blueprint $table)
		{
			$table->foreign('user_id', 'users_to_class_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('class_id', 'users_to_class_ibfk_2')->references('id')->on('classes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('session_id', 'users_to_class_ibfk_3')->references('id')->on('school_session')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('stream_id', 'users_to_class_ibfk_4')->references('id')->on('streams')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('section_id', 'users_to_class_ibfk_5')->references('id')->on('sections')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_to_class', function(Blueprint $table)
		{
			$table->dropForeign('users_to_class_ibfk_1');
			$table->dropForeign('users_to_class_ibfk_2');
			$table->dropForeign('users_to_class_ibfk_3');
			$table->dropForeign('users_to_class_ibfk_4');
			$table->dropForeign('users_to_class_ibfk_5');
		});
	}

}
