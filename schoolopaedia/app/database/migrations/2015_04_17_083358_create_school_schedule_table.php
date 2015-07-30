<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchoolScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('school_schedule', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('start_from');
			$table->date('close_untill');
			$table->time('opening_time');
			$table->time('lunch_time');
			$table->time('closing_time');
			$table->integer('school_id')->index('school_id');
			$table->integer('school_session_id')->index('school_session_id');
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
		Schema::drop('school_schedule');
	}

}
