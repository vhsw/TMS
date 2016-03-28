<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventorySupplierTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (! Schema::hasTable('suppliers'))
        {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('shortname');
                $table->string('address')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('zip_code')->nullable();
                $table->string('region')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->nullable();
                $table->string('contact_title')->nullable();
                $table->string('contact_name')->nullable();
                $table->string('contact_phone')->nullable();
                $table->string('contact_fax')->nullable();
                $table->string('contact_email')->nullable();
                $table->text('website')->nullable();
                $table->boolean('producer')->default(0);
                $table->integer('supplied_by')->default(0);

                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }

        if (! Schema::hasTable('inventory_suppliers'))
        {
            Schema::create('inventory_suppliers', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('inventory_id')->unsigned();
                $table->integer('supplier_id')->unsigned();
                $table->decimal('cost', 8, 2);

                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                $table->foreign('inventory_id')->references('id')->on('inventories')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');

                $table->foreign('supplier_id')->references('id')->on('suppliers')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inventory_suppliers');
        Schema::dropIfExists('suppliers');
    }
}
