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
				$table->integer('year', 4);
				$table->integer('month', 2);
				$table->decimal('budget', 8, 2);
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
		Schema::drop('statistic_expenses');
	}

}
