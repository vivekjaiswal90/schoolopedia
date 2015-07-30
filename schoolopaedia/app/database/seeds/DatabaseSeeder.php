<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Eloquent::unguard();

        $this->call('UsersTableSeeder');

        $this->command->info('User table seeded!');
		$this->call('GroupsTableSeeder');
		$this->call('SchoolSessionTableSeeder');
		$this->call('SchoolsTableSeeder');
		$this->call('StreamsTableSeeder');
		$this->call('ClassesTableSeeder');
		$this->call('SectionsTableSeeder');
		$this->call('SubjectsTableSeeder');
		$this->call('UsersToClassTableSeeder');
		$this->call('TimetableTableSeeder');
		$this->call('SchoolScheduleTableSeeder');
		$this->call('UsersLoginInfoTableSeeder');
		$this->call('UsersRegisteredToSessionTableSeeder');
	}

}
