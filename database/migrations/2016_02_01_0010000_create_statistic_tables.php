<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('statistic_expenses'))
		{
			Schema::create('statistic_expenses', function(Blueprint $table)
			{
				$table->integer('year')->unsigned();
				$table->integer('month')->unsigned();
				$table->decimal('budget', 8, 2);
				$table->decimal('cost', 8, 2);
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
		Schema::drop('statistic_expenses');
	}

}
