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
				$table->integer('inventory_id')->unsigned();
				$table->text('title');
				$table->text('description');
				$table->timestamps();
                $table->softDeletes();

				$table->foreign('inventory_id')->references('id')->on('inventories')
                    ->onUpdate('restrict')
                    ->onDelete('set null');

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
