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
				$table->increments('id');
				$table->string('name')->index();
				$table->string('shortname')->index();
				$table->tinyInteger('producer')->default(0);
				$table->string('website')->index();
				$table->string('phone')->index();
				$table->integer('supplied_by')->unsigned();
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
		Schema::drop('suppliers');
	}

}