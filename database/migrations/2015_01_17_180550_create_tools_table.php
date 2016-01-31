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
				$table->string('serialnr')->unique()->index();
				$table->string('name0')->index();
				$table->string('name1')->index();
				$table->string('barcode')->unique()->index();
				$table->integer('category_id')->default(0);
				$table->integer('supplier_id')->default(0);
				$table->timestamps();
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
