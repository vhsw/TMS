<?php

namespace App\Models;

use DB;
use App\Interfaces\StateableInterface;
use App\Traits\InventoryTransactionTrait;

class InventoryTransaction extends BaseModel implements StateableInterface
{
    use InventoryTransactionTrait;

    protected $table = 'inventory_transactions';

    protected $fillable = array(
        'user_id',
        'stock_id',
        'name',
        'state',
        'quantity',
    );

    public function stock()
    {
        return $this->belongsTo('App\Models\InventoryStock', 'stock_id', 'id');
    }

    public function histories()
    {
        return $this->hasMany('App\Models\InventoryTransactionHistory', 'transaction_id', 'id');
    }


    public function addCost($cost, $supplier_id)
    {
        DB::table('inventory_suppliers')->insert([
            'inventory_id' => $this->stock->item->id,
            'supplier_id'  => $supplier_id,
            'cost'         => $cost
        ]);

        return true;
    }

    public function changeQuantityTo($quantity)
    {
        // Updates the quantity
        $this->quantity = $quantity;
        $this->original_quantity = $quantity;
        $this->save();
    }
}
