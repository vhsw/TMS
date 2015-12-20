<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('cost'))
		{
			Schema::create('cost', function(Blueprint $table)
			{
				$table->integer('tool_id')->unsigned();
				$table->integer('supplier_id')->unsigned();
				$table->decimal('cost', 8, 2);
				$table->timestamps();
				$table->engine = 'InnoDB';
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
		Schema::drop('cost');
	}

}