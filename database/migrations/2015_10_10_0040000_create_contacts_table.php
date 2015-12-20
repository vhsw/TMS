<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('suppliers'))
		{
			Schema::create('suppliers', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->string('name');
				$table->tinyInteger('producer')->default(0);
				$table->string('website');
				$table->integer('phone');
				$table->integer('supplied_by')->unsigned();
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
		Schema::drop('suppliers');
	}

}