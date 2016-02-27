<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        if (! Schema::hasTable('locations_tools'))
        {

            // Create table for associating roles to users (Many-to-Many)
            Schema::create('locations_tools', function (Blueprint $table) 
            {
                $table->increments('id')->unsigned;
                $table->integer('location_id')->unsigned();
                $table->integer('tool_id')->unsigned();
                $table->integer('user_id')->default(0);
                $table->integer('old_quantity')->default(0);
                $table->integer('new_quantity')->default(0);

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
     * @return  void
     */
    public function down()
    {
        Schema::drop('locations_tools');

    }
}
