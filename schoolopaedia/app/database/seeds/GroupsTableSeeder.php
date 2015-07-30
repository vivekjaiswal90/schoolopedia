<?php

class GroupsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('groups')->delete();
        
		\DB::table('groups')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'students',
				'permissions' => '',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-01 00:00:00',
				'updated_at' => '2015-04-01 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'administratior',
				'permissions' => '',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-01 00:00:00',
				'updated_at' => '2015-04-01 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'teachers',
				'permissions' => '',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-01 00:00:00',
				'updated_at' => '2015-04-01 00:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'moderators',
				'permissions' => '',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-01 00:00:00',
				'updated_at' => '2015-04-01 00:00:00',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'parents',
				'permissions' => '',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-01 00:00:00',
				'updated_at' => '2015-04-01 00:00:00',
			),
		));
	}

}
