<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('tools'))
		{
			Schema::create('tools', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('serialnr');
				$table->string('name0');
				$table->string('name1');
				$table->string('barcode');
				$table->integer('category_id')->default(0);
				$table->integer('supplier_id')->default(0);
				$table->timestamps();

				$table->engine = 'InnoDB';
				$table->index('serialnr');
				$table->index('name0');
				$table->index('name1');
				$table->index('barcode');
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
		Schema::drop('tools');
	}

}
