<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (! Schema::hasTable('inventories'))
        {
            Schema::create('inventories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id')->unsigned()->nullable();
                $table->integer('user_id')->unsigned()->nullable();
                $table->integer('metric_id')->unsigned();
                $table->integer('brand_id')->unsigned()->nullable();
                $table->string('name');
                $table->string('name0');
                $table->string('serialnr');
                $table->text('description')->nullable();

                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->softDeletes();

                $table->foreign('category_id')->references('id')->on('categories')
                    ->onUpdate('restrict')
                    ->onDelete('set null');

                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('set null');

                $table->foreign('metric_id')->references('id')->on('metrics')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');

                $table->foreign('brand_id')->references('id')->on('suppliers')
                    ->onUpdate('restrict')
                    ->onDelete('set null');
            });
        }

        if (! Schema::hasTable('inventory_stocks'))
        {
            Schema::create('inventory_stocks', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable();
                $table->integer('inventory_id')->unsigned();
                $table->integer('location_id')->unsigned();
                $table->decimal('quantity', 8, 2)->default(0);
                $table->string('aisle')->nullable();
                $table->string('row')->nullable();
                $table->string('bin')->nullable();

                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                /*
                 * This allows only one inventory stock to be created
                 * on a single location
                 */
                $table->unique(['inventory_id', 'location_id']);

                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('set null');

                $table->foreign('inventory_id')->references('id')->on('inventories')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');

                $table->foreign('location_id')->references('id')->on('locations')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('inventory_stock_movements'))
        {
            Schema::create('inventory_stock_movements', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('stock_id')->unsigned();
                $table->integer('user_id')->unsigned()->nullable();
                $table->decimal('before', 8, 2)->default(0);
                $table->decimal('after', 8, 2)->default(0);
                $table->decimal('cost', 8, 2)->default(0)->nullable();
                $table->string('reason')->nullable();

                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                $table->foreign('stock_id')->references('id')->on('inventory_stocks')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');

                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inventory_stock_movements');
        Schema::dropIfExists('inventory_stocks');
        Schema::dropIfExists('inventories');
    }
}
