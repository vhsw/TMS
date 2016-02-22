<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesToolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('pictures_tools'))
		{
			Schema::create('pictures_tools', function(Blueprint $table)
			{
				$table->integer('tool_id')->default(null);
				$table->integer('picture_id')->default(null);
				$table->boolean('first_choice')->default(0);
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
		Schema::drop('pictures_tools');
	}

}