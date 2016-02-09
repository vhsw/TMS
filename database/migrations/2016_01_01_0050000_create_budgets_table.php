<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('budget'))
		{
			Schema::create('budget', function(Blueprint $table)
			{
				$table->increments('id'); // Month Id
				$table->decimal('_'.date('Y'), 8, 2)->default('0.00');
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
		Schema::drop('budget');
	}

}