<?php

namespace App\Models;

use App\Traits\InventoryStockTrait;

class InventoryStock extends BaseModel
{
    use InventoryStockTrait;

    protected $table = 'inventory_stocks';

    protected $fillable = array(
        'inventory_id',
        'location_id',
        'quantity',
        'aisle',
        'row',
        'bin',
    );

    public function item()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id');
    }

    public function movements()
    {
        return $this->hasMany('App\Models\InventoryStockMovement', 'stock_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\InventoryTransaction', 'stock_id', 'id');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public static function createEmptyStock($item)
    {
        $stock = $item->newStockOnLocation(Location::find(1));

        $stock->quantity = 0;
        $stock->reason = 'stock created';
        $stock->save();

        return $stock;
    }
}
