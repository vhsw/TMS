<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('locations'))
		{
			Schema::create('locations', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->string('location')->index();
				$table->string('name')->index();
			});
		}

		if (! Schema::hasTable('stock_connections'))
        {

            // Create table for associating roles to users (Many-to-Many)
            Schema::create('stock_connections', function (Blueprint $table) 
            {
                $table->increments('id')->unsigned;
                $table->integer('location_id')->unsigned();
                $table->integer('tool_id')->unsigned();
                $table->integer('quantity')->default(0);

                $table->timestamp('updated_at');
                $table->timestamp('created_at');
                $table->timestamp('deleted_at');

                $table->foreign('location_id')->references('id')->on('locations');
                $table->foreign('tool_id')->references('id')->on('tools');
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
		Schema::drop('locations');
		Schema::drop('stock_connections');
	}

}
