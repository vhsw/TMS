<?php

namespace App\Models;

use App\Traits\InventoryTrait;
use App\Traits\InventoryVariantTrait;

class Inventory extends BaseModel
{
    use InventoryTrait;
    use InventoryVariantTrait;

    protected $table = 'inventories';

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

    public function metric()
    {
        return $this->hasOne('App\Models\Metric', 'id', 'metric_id');
    }

    public function sku()
    {
        return $this->hasOne('App\Models\InventorySku', 'inventory_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany('App\Models\InventoryStock', 'inventory_id');
    }

    public function suppliers()
    {
        return $this->belongsToMany('App\Models\Supplier', 'inventory_suppliers', 'inventory_id')->withTimestamps();
    }

    /**
    * Returns an item record by the specified Serialnr.
    *
    * @param string serialnr
    *
    * @return bool
    */
    public static function findBySerialnr($serialnr)
    {
        $instance = new static();
        /*
        * Try and find the Barcode
        */
        $tool = $instance->where('serialnr', $serialnr)->first();

        /*
        * Check if the Tool was found
        */
        if ($tool) {
            return $tool;
        }

        /*
        * Return false on failure
        */
        return false;
    }
}
