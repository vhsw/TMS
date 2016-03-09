<?php

namespace App\Models;

use App\Traits\InventoryTransactionTrait;
use App\Interfaces\StateableInterface;

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
}
