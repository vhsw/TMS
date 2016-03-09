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
		/*if (! Schema::hasTable('details'))
		{
			Schema::create('details', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->integer('tool_id')->unsigned();
				$table->text('title1');
				$table->text('title2');
				$table->text('cuttingdata');
				$table->text('description');

				$table->timestamp('updated_at');
                $table->timestamp('created_at');
                $table->timestamp('deleted_at');

                $table->foreign('tool_id')->references('id')->on('tools');

			});
		}*/
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
