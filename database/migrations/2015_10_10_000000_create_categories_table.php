<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('categories'))
		{
			Schema::create('categories', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->integer('parent_id')->default(0);
				$table->integer('sort');
				$table->string('name')->index();
				$table->text('data');
				$table->string('icon');
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
		Schema::drop('categories');
	}

}
