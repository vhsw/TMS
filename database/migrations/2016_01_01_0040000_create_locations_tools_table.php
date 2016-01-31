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
                $table->integer('location_id')->unsigned();
                $table->integer('tool_id')->unsigned();
                $table->integer('amount')->unsigned();
                $table->engine = 'InnoDB';
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
