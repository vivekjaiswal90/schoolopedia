<?php

class TimetableTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('timetable')->delete();
        
		\DB::table('timetable')->insert(array (
			0 => 
			array (
				'id' => 1,
				'start_time' => '06:16:00',
				'end_time' => '18:15:00',
				'class_id' => 6,
				'subject_id' => 1,
				'section_id' => 1,
				'users_id' => 14,
				'day_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-04-07 07:16:14',
			),
			1 => 
			array (
				'id' => 2,
				'start_time' => '16:04:00',
				'end_time' => '17:04:00',
				'class_id' => 6,
				'subject_id' => 3,
				'section_id' => 1,
				'users_id' => 15,
				'day_id' => 2,
				'deleted_at' => '2015-04-07 07:20:12',
				'created_at' => '2015-04-07 07:04:42',
				'updated_at' => '2015-04-07 07:20:12',
			),
			2 => 
			array (
				'id' => 3,
				'start_time' => '16:08:00',
				'end_time' => '17:08:00',
				'class_id' => 6,
				'subject_id' => 4,
				'section_id' => 1,
				'users_id' => 15,
				'day_id' => 3,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-07 07:08:25',
				'updated_at' => '2015-04-07 07:08:25',
			),
			3 => 
			array (
				'id' => 4,
				'start_time' => '19:24:00',
				'end_time' => '20:09:00',
				'class_id' => 6,
				'subject_id' => 3,
				'section_id' => 1,
				'users_id' => 15,
				'day_id' => 4,
				'deleted_at' => '2015-04-07 07:20:28',
				'created_at' => '2015-04-07 07:10:04',
				'updated_at' => '2015-04-07 07:20:28',
			),
			4 => 
			array (
				'id' => 5,
				'start_time' => '17:34:00',
				'end_time' => '18:34:00',
				'class_id' => 1,
				'subject_id' => 5,
				'section_id' => 11,
				'users_id' => 18,
				'day_id' => 5,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-07 07:34:27',
				'updated_at' => '2015-04-07 07:34:27',
			),
			5 => 
			array (
				'id' => 6,
				'start_time' => '18:08:00',
				'end_time' => '18:08:00',
				'class_id' => 1,
				'subject_id' => 5,
				'section_id' => 11,
				'users_id' => 15,
				'day_id' => 6,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-07 07:39:57',
				'updated_at' => '2015-04-08 07:08:12',
			),
			6 => 
			array (
				'id' => 7,
				'start_time' => '16:00:00',
				'end_time' => '16:00:00',
				'class_id' => 1,
				'subject_id' => 5,
				'section_id' => 11,
				'users_id' => 15,
				'day_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-08 07:00:54',
				'updated_at' => '2015-04-08 07:00:54',
			),
			7 => 
			array (
				'id' => 8,
				'start_time' => '04:15:00',
				'end_time' => '05:15:00',
				'class_id' => 1,
				'subject_id' => 5,
				'section_id' => 11,
				'users_id' => 14,
				'day_id' => 1,
				'deleted_at' => '2015-04-13 08:46:07',
				'created_at' => '2015-04-08 07:18:10',
				'updated_at' => '2015-04-13 08:46:07',
			),
			8 => 
			array (
				'id' => 9,
				'start_time' => '05:15:00',
				'end_time' => '07:15:00',
				'class_id' => 1,
				'subject_id' => 5,
				'section_id' => 11,
				'users_id' => 15,
				'day_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-13 08:23:20',
				'updated_at' => '2015-04-13 08:28:31',
			),
			9 => 
			array (
				'id' => 10,
				'start_time' => '16:45:00',
				'end_time' => '17:45:00',
				'class_id' => 2,
				'subject_id' => 6,
				'section_id' => 13,
				'users_id' => 14,
				'day_id' => 1,
				'deleted_at' => '2015-04-13 08:49:05',
				'created_at' => '2015-04-13 08:48:58',
				'updated_at' => '2015-04-13 08:49:05',
			),
			10 => 
			array (
				'id' => 11,
				'start_time' => '14:45:00',
				'end_time' => '17:45:00',
				'class_id' => 2,
				'subject_id' => 6,
				'section_id' => 13,
				'users_id' => 14,
				'day_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-13 08:49:25',
				'updated_at' => '2015-04-13 08:49:25',
			),
			11 => 
			array (
				'id' => 12,
				'start_time' => '18:45:00',
				'end_time' => '17:45:00',
				'class_id' => 2,
				'subject_id' => 7,
				'section_id' => 13,
				'users_id' => 15,
				'day_id' => 2,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-13 08:50:19',
				'updated_at' => '2015-04-13 08:50:19',
			),
			12 => 
			array (
				'id' => 13,
				'start_time' => '17:45:00',
				'end_time' => '18:45:00',
				'class_id' => 2,
				'subject_id' => 6,
				'section_id' => 13,
				'users_id' => 14,
				'day_id' => 2,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-13 08:50:57',
				'updated_at' => '2015-04-13 08:50:57',
			),
		));
	}

}
