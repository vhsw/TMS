<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarcodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*if (! Schema::hasTable('barcodes'))
		{
			Schema::create('barcodes', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->integer('tool_id')->unsigned();
				$table->string('barcode')->unique()->index();
				
				$table->timestamp('updated_at');
                $table->timestamp('created_at');
                $table->timestamp('deleted_at');

                $table->foreign('tool_id')->references('id')->on('tools');
			});
		}*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('barcodes');
	}

}
