<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('objects_files'))
		{
			Schema::create('objects_files', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('object_id')->default(0);
				$table->string('object_type')->index();
				$table->string('file_id');
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('objects_files');
	}

}
