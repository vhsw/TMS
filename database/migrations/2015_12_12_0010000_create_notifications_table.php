<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (! Schema::hasTable('notifications'))
		{
			Schema::create('notifications', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('user_id')->unsigned();

				$table->string('type', 128)->nullable();
				$table->string('status', 120)->nullable();
				$table->text('body')->nullable;

				$table->integer('object_id')->unsigned();
				$table->string('object_type', 128);

				$table->boolean('is_read')->default(0);
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
		Schema::drop('notifications');
	}

}