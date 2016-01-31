<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('requests'))
		{
			Schema::create('requests', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('description')->index();
				$table->string('tool_serialnr')->index();
				$table->integer('tool_id')->unsigned();
				$table->integer('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users');
				$table->string('barcode')->index();
				$table->integer('amount')->default(0);
				$table->text('comments');
				$table->string('status');
				$table->decimal('cost', 8, 2);
				$table->timestamps();
				$table->softDeletes();
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
		Schema::drop('requests');
	}

}