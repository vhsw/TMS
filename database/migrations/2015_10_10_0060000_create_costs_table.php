<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('costs'))
		{
			Schema::create('costs', function(Blueprint $table)
			{
				$table->integer('tool_id')->unsigned();
				$table->integer('supplier_id')->unsigned();
				$table->decimal('cost', 8, 2);
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
		Schema::drop('costs');
	}

}