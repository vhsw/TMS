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
				$table->string('name')->index();
				$table->string('short_name')->index();
				$table->string('controller')->index();
				
				$table->timestamp('updated_at');
                $table->timestamp('created_at');
                $table->timestamp('deleted_at');
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