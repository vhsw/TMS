<?php

namespace App\Models;

use App\Traits\InventorySkuTrait;

class InventorySku extends BaseModel
{
    use InventorySkuTrait;

    protected $table = 'inventory_skus';

    protected $fillable = array(
        'inventory_id',
        'code',
    );

    public function item()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id');
    }
}
