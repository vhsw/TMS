<?php

namespace App\Models;

use App\Traits\InventoryTransactionHistoryTrait;

class InventoryTransactionHistory extends BaseModel
{
    use InventoryTransactionHistoryTrait;

    protected $table = 'inventory_transaction_histories';

    protected $fillable = array(
        'user_id',
        'transaction_id',
        'state_before',
        'state_after',
        'quantity_before',
        'quantity_after',
    );

    public function transaction()
    {
        return $this->belongsTo('InventoryTransaction', 'transaction_id', 'id');
    }
}
