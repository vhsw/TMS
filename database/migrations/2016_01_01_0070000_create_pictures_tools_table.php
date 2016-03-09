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
		/*if (! Schema::hasTable('pictures_tools'))
		{
			Schema::create('pictures_tools', function(Blueprint $table)
			{
				$table->integer('tool_id')->unsigned();
				$table->integer('picture_id')->unsigned();
				$table->boolean('first_choice')->default(0);

				$table->timestamp('updated_at');
                $table->timestamp('created_at');
                $table->timestamp('deleted_at');

                $table->foreign('tool_id')->references('id')->on('tools');
                $table->foreign('picture_id')->references('id')->on('pictures');
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
		Schema::drop('pictures_tools');
	}

}
