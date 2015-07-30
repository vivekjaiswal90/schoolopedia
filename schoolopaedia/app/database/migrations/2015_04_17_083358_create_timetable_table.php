<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimetableTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timetable', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->time('start_time');
			$table->time('end_time');
			$table->integer('class_id')->index('classes_id');
			$table->integer('subject_id')->index('subject_id');
			$table->integer('section_id')->index('section_id');
			$table->integer('users_id')->index('users_id');
			$table->boolean('day_id');
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
		Schema::drop('timetable');
	}

}
