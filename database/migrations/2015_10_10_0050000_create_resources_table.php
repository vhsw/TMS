<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('resources'))
		{
			Schema::create('resources', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->string('name');
				$table->string('short_name');
				$table->string('controller');
				$table->timestamps();

				$table->engine = 'InnoDB';
				$table->index('name');
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
		Schema::drop('resources');
	}

}