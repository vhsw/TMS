<?php

namespace App\Models;

use App\Traits\InventoryStockMovementTrait;

class InventoryStockMovement extends BaseModel
{
    use InventoryStockMovementTrait;

    protected $table = 'inventory_stock_movements';

    protected $fillable = array(
        'stock_id',
        'user_id',
        'before',
        'after',
        'cost',
        'reason',
    );

    public function stock()
    {
        return $this->belongsTo('App\Models\InventoryStock', 'stock_id', 'id');
    }
}
