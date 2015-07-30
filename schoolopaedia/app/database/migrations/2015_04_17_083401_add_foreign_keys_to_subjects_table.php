<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subjects', function(Blueprint $table)
		{
			$table->foreign('class_id', 'subjects_ibfk_1')->references('id')->on('classes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('section_id', 'subjects_ibfk_2')->references('id')->on('sections')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subjects', function(Blueprint $table)
		{
			$table->dropForeign('subjects_ibfk_1');
			$table->dropForeign('subjects_ibfk_2');
		});
	}

}
