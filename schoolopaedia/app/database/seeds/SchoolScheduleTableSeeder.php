<?php

class SchoolScheduleTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('school_schedule')->delete();
        
		\DB::table('school_schedule')->insert(array (
			0 => 
			array (
				'id' => 23,
				'start_from' => '2015-04-01',
				'close_untill' => '2016-03-31',
				'opening_time' => '09:00:00',
				'lunch_time' => '12:15:00',
				'closing_time' => '03:15:00',
				'school_id' => 7,
				'school_session_id' => 2,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 03:29:51',
				'updated_at' => '2015-04-15 03:29:51',
			),
		));
	}

}
