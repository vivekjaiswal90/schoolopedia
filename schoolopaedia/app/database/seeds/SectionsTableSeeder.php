<?php

class SectionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('sections')->delete();
        
		\DB::table('sections')->insert(array (
			0 => 
			array (
				'id' => 1,
				'section_name' => 'Section - A',
				'class_id' => 6,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:28:26',
				'updated_at' => '2015-03-27 07:28:26',
			),
			1 => 
			array (
				'id' => 2,
				'section_name' => 'Section - B',
				'class_id' => 6,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:28:35',
				'updated_at' => '2015-03-27 07:28:35',
			),
			2 => 
			array (
				'id' => 3,
				'section_name' => 'Section - C',
				'class_id' => 6,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:28:43',
				'updated_at' => '2015-03-27 07:28:43',
			),
			3 => 
			array (
				'id' => 4,
				'section_name' => 'Section - A',
				'class_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:28:56',
				'updated_at' => '2015-03-27 07:28:56',
			),
			4 => 
			array (
				'id' => 5,
				'section_name' => 'Section - B',
				'class_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:29:04',
				'updated_at' => '2015-03-27 07:29:04',
			),
			5 => 
			array (
				'id' => 6,
				'section_name' => 'Section - C',
				'class_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:29:14',
				'updated_at' => '2015-03-27 07:29:14',
			),
			6 => 
			array (
				'id' => 7,
				'section_name' => 'Section - A',
				'class_id' => 10,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:29:40',
				'updated_at' => '2015-03-27 07:29:40',
			),
			7 => 
			array (
				'id' => 8,
				'section_name' => 'Section - B',
				'class_id' => 10,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:29:47',
				'updated_at' => '2015-03-27 07:29:47',
			),
			8 => 
			array (
				'id' => 9,
				'section_name' => 'Section - C',
				'class_id' => 10,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:29:54',
				'updated_at' => '2015-03-27 07:29:54',
			),
			9 => 
			array (
				'id' => 10,
				'section_name' => 'Section - A',
				'class_id' => 17,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:37:33',
				'updated_at' => '2015-03-27 07:37:33',
			),
			10 => 
			array (
				'id' => 11,
				'section_name' => 'Section - A',
				'class_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-30 08:16:33',
				'updated_at' => '2015-03-30 08:16:33',
			),
			11 => 
			array (
				'id' => 12,
				'section_name' => 'Section - 1',
				'class_id' => 23,
				'deleted_at' => '2015-03-30 08:20:35',
				'created_at' => '2015-03-30 08:20:28',
				'updated_at' => '2015-03-30 08:20:35',
			),
			12 => 
			array (
				'id' => 13,
				'section_name' => 'Section - A',
				'class_id' => 2,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-13 08:47:29',
				'updated_at' => '2015-04-13 08:47:29',
			),
			13 => 
			array (
				'id' => 14,
				'section_name' => 'Section - A',
				'class_id' => 27,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 06:03:44',
				'updated_at' => '2015-04-15 06:03:44',
			),
			14 => 
			array (
				'id' => 15,
				'section_name' => 'Section - B',
				'class_id' => 27,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 06:03:53',
				'updated_at' => '2015-04-15 06:03:53',
			),
			15 => 
			array (
				'id' => 16,
				'section_name' => 'Section - A',
				'class_id' => 28,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 06:05:57',
				'updated_at' => '2015-04-15 06:05:57',
			),
			16 => 
			array (
				'id' => 17,
				'section_name' => 'Section - B',
				'class_id' => 28,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 06:06:06',
				'updated_at' => '2015-04-15 06:06:06',
			),
			17 => 
			array (
				'id' => 18,
				'section_name' => 'Section - C',
				'class_id' => 28,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 06:08:29',
				'updated_at' => '2015-04-15 06:15:23',
			),
		));
	}

}
