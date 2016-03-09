<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*if (! Schema::hasTable('pictures'))
		{
			Schema::create('pictures', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->string('title')->index();
				$table->string('path')->index();

				$table->timestamp('updated_at');
                $table->timestamp('created_at');
                $table->timestamp('deleted_at');
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
		Schema::drop('pictures');
	}

}
