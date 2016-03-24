<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesInventoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('pictures_inventories'))
		{
			Schema::create('pictures_inventories', function(Blueprint $table)
			{
				$table->increments('id');
                $table->timestamps();

				$table->integer('inventory_id')->unsigned();
				$table->integer('picture_id')->unsigned();
				$table->boolean('first_choice')->default(0);

				$table->foreign('inventory_id')->references('id')->on('inventories')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');

                $table->foreign('picture_id')->references('id')->on('pictures')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');
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
		Schema::drop('pictures_inventories');
	}

}
