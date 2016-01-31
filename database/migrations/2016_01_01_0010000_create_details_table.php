<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('details'))
		{
			Schema::create('details', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('tool_id')->default(0);
				$table->text('title1');
				$table->text('title2');
				$table->text('cuttingdata');
				$table->text('description');
				$table->timestamps();

				$table->engine = 'InnoDB';
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
		Schema::drop('details');
	}

}
