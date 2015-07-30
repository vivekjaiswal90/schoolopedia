<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTimetableTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('timetable', function(Blueprint $table)
		{
			$table->foreign('subject_id', 'timetable_ibfk_1')->references('id')->on('subjects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('users_id', 'timetable_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('class_id', 'timetable_ibfk_3')->references('id')->on('classes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('section_id', 'timetable_ibfk_4')->references('id')->on('sections')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('timetable', function(Blueprint $table)
		{
			$table->dropForeign('timetable_ibfk_1');
			$table->dropForeign('timetable_ibfk_2');
			$table->dropForeign('timetable_ibfk_3');
			$table->dropForeign('timetable_ibfk_4');
		});
	}

}
