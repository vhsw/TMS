<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTransactionTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (! Schema::hasTable('inventory_transactions'))
        {
            Schema::create('inventory_transactions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable();
                $table->integer('stock_id')->unsigned();
                $table->string('name')->nullable();
                $table->string('state');
                $table->decimal('quantity', 8, 2)->default(0);
                $table->decimal('original_quantity', 8, 2)->default(0);
                $table->text('comments');

                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('set null');

                $table->foreign('stock_id')->references('id')->on('inventory_stocks')
                    ->onUpdate('restrict')
                    ->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('inventory_transaction_histories'))
        {
            Schema::create('inventory_transaction_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable();
                $table->integer('transaction_id')->unsigned();

                /*
                 * Allows tracking states for each transaction
                 */
                $table->string('state_before');
                $table->string('state_after');

                /*
                 * Allows tracking the quantities of each transaction
                 */
                $table->string('quantity_before');
                $table->string('quantity_after');

                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('set null');

                $table->foreign('transaction_id')->references('id')->on('inventory_transactions')
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
        Schema::dropIfExists('inventory_transaction_histories');
        Schema::dropIfExists('inventory_transactions');
    }
}
