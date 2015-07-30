<?php

class SubjectsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('subjects')->delete();
        
		\DB::table('subjects')->insert(array (
			0 => 
			array (
				'id' => 1,
				'subject_name' => 'Hindi',
				'subject_code' => 'CS0101',
				'class_id' => 6,
				'section_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'subject_name' => 'Hindi',
				'subject_code' => 'CS100B01',
				'class_id' => 6,
				'section_id' => 2,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-04-07 02:54:41',
			),
			2 => 
			array (
				'id' => 3,
				'subject_name' => 'English',
				'subject_code' => 'CS0201',
				'class_id' => 6,
				'section_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-07 02:16:40',
				'updated_at' => '2015-04-07 02:51:52',
			),
			3 => 
			array (
				'id' => 4,
				'subject_name' => 'Mathematics',
				'subject_code' => 'CS0103',
				'class_id' => 6,
				'section_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-07 02:23:42',
				'updated_at' => '2015-04-07 02:23:42',
			),
			4 => 
			array (
				'id' => 5,
				'subject_name' => 'Hindi',
				'subject_code' => 'CS010A01',
				'class_id' => 1,
				'section_id' => 11,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-07 07:33:45',
				'updated_at' => '2015-04-07 07:33:45',
			),
			5 => 
			array (
				'id' => 6,
				'subject_name' => 'Hindi',
				'subject_code' => 'CS020A01',
				'class_id' => 2,
				'section_id' => 13,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-13 08:48:20',
				'updated_at' => '2015-04-13 08:48:20',
			),
			6 => 
			array (
				'id' => 7,
				'subject_name' => 'English',
				'subject_code' => 'CS020A02',
				'class_id' => 2,
				'section_id' => 13,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-13 08:48:37',
				'updated_at' => '2015-04-13 08:48:37',
			),
			7 => 
			array (
				'id' => 8,
				'subject_name' => 'Hindi',
				'subject_code' => 'CS0N010A1',
				'class_id' => 27,
				'section_id' => 14,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 06:09:48',
				'updated_at' => '2015-04-15 06:09:48',
			),
			8 => 
			array (
				'id' => 9,
				'subject_name' => 'Hindi',
				'subject_code' => 'CS0N020A01',
				'class_id' => 28,
				'section_id' => 16,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 06:21:25',
				'updated_at' => '2015-04-15 06:21:25',
			),
			9 => 
			array (
				'id' => 10,
				'subject_name' => 'English',
				'subject_code' => 'CS0N020A02',
				'class_id' => 28,
				'section_id' => 16,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 06:22:40',
				'updated_at' => '2015-04-15 06:22:40',
			),
		));
	}

}
