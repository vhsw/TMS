<?php

namespace App\Models;

use App\Traits\InventoryTrait;
use App\Traits\InventoryVariantTrait;

// TODO:    When creating or updating Barcode, need to check
//          if barcode already exist in database and throw Exception

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

    public function barcode()
    {
        return $this->hasOne('App\Models\Barcode', 'inventory_id', 'id');
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

        $tool = $instance->where('serialnr', $serialnr)->first();

        if ($tool) {
            return $tool;
        }

        return false;
    }

    /**
     * Returns true/false if the current item has an Barcode.
     *
     * @return bool
     */
    public function hasBarcode()
    {
        if ($this->barcode) {
            return true;
        }
        return false;
    }

    /**
     * Returns the item's Barcode.
     *
     * @return null|string
     */
    public function getBarcode()
    {
        if ($this->hasBarcode()) {
            return $this->barcode->barcode;
        }
        return;
    }

    /**
     * Returns an item record by the specified Barcode.
     *
     * @param string $barcode
     *
     * @return bool
     */
    public static function findByBarcode($barcode)
    {
        $instance = new static();

        $barcode = $instance
            ->sku()
            ->getRelated()
            ->with('item')
            ->where('barcode', $barcode)
            ->first();

        if ($barcode && $barcode->item) {
            return $barcode->item;
        }

        return false;
    }

    /**
     * Updates the items current Barcode or the Barcode
     * supplied with the specified code.
     *
     * @param null   $barcode
     *
     * @return mixed|bool
     */
    public function updateBarcode($barcode)
    {
        $this->dbStartTransaction();
        try {
            if ($this->barcode->update(compact('barcode'))) {
                $this->dbCommitTransaction();
                return $barcode;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }
        return false;
    }
}