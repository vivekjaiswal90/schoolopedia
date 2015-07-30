<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSchoolScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('school_schedule', function(Blueprint $table)
		{
			$table->foreign('school_id', 'school_schedule_ibfk_1')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('school_session_id', 'school_schedule_ibfk_2')->references('id')->on('school_session')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('school_schedule', function(Blueprint $table)
		{
			$table->dropForeign('school_schedule_ibfk_1');
			$table->dropForeign('school_schedule_ibfk_2');
		});
	}

}
