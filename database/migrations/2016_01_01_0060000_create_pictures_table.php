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
		if (! Schema::hasTable('pictures'))
		{
			Schema::create('pictures', function(Blueprint $table)
			{
				$table->increments('id');
				$table->timestamps();
                $table->softDeletes();
				$table->string('title');
				$table->string('path');
				$table->integer('width');
				$table->integer('height');
				$table->string('type');
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
		Schema::drop('pictures');
	}

}
