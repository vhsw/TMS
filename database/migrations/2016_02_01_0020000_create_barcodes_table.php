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
		if (! Schema::hasTable('barcodes'))
        {
            Schema::create('barcodes', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->integer('inventory_id')->unsigned();
                $table->string('barcode');

                $table->foreign('inventory_id')->references('id')->on('inventories')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');

                /*
                 * Make sure each SKU is unique
                 */
                $table->unique(['barcode']);
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
		Schema::drop('barcodes');
	}

}
