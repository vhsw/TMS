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
				$table->string('title');
				$table->string('path');
				$table->integer('width');
				$table->integer('height');
				$table->string('type');

				$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->softDeletes();
			});
		}

		if (! Schema::hasTable('pictures_inventories'))
		{
			Schema::create('pictures_inventories', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('inventory_id')->unsigned();
				$table->integer('picture_id')->unsigned();
				$table->boolean('first_choice')->default(0);

				$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->softDeletes();

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
		Schema::drop('pictures');
	}

}
