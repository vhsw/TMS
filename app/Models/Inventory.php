<?php

namespace App\Models;

use DB;
use App\Models\Detail;
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
        return $this->belongsToMany('App\Models\Supplier', 'inventory_suppliers', 'inventory_id')->withTimestamps()->withPivot('cost');
    }

    public function brand()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'brand_id');
    }

    public function details()
    {
        return $this->hasOne('App\Models\Detail', 'inventory_id', 'id');
    }

    public function pictures()
    {
        return $this->belongsToMany('App\Models\Picture', 'pictures_inventories', 'inventory_id', 'picture_id')->withPivot('first_choice');
    }

    /**
     * Returns the total quantity of this items stocks.
     *
     * @return Int
     */
    public function getTotalStockQuantity()
    {
        $quantity = $this->stocks()->sum('quantity');

        return $quantity;
    }

    /**
     * Returns the current supplier pivot table.
     *
     * @return Object
     */
    public function getCurrentSupplierPivot()
    {
        $supplier = DB::table('inventory_suppliers')
                ->where('inventory_id', $this->id)
                ->orderBy('created_at', 'desc')->first();

        return $supplier;
    }

    /**
     * Returns a list of all costs for this item.
     *
     * @return Collection
     */
    public function getAllCosts()
    {
        $suppliers = $this->suppliers;
        $pivots = $suppliers->pluck('pivot')
                ->sortBy('created_at');

        return $pivots;
    }

    /**
     * Gets the current supplier.
     *
     * @return Object
     */
    public function getCurrentSupplier()
    {
        $supplier = $this->getCurrentSupplierPivot();
        return Supplier::find($supplier->supplier_id);
    }

    /**
     * Gets the current supplier cost.
     *
     * @return decimal
     */
    public function getCurrentSupplierCost()
    {
        return $this->getCurrentSupplierPivot()->cost;
    }

    /**
     * Returns a supplier by the specified ID.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    private function getSupplierById($id)
    {
        return Supplier::find($id);
    }

    /**
    * Change the brand of the Inventory.
    *
    * @param integer    supplier
    *
    * @return bool
    */
    public function changeBrandTo($supplier)
    {
        $this->brand_id = $supplier;
        $this->save();

        return true;
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
        $item = Inventory::with('category')
            ->with('suppliers')
            ->where('serialnr', $serialnr)->first();

        if ($item) {
            return $item;
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
     * Returns true/false if the current item has Details.
     *
     * @return bool
     */
    public function hasDetails()
    {
        if ($this->details) {
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
     * Returns the item's Details.
     *
     * @return null|string
     */
    public function getDetails()
    {
        if ($this->hasDetails()) {
            return $this->details;
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
            ->barcode()
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

    /**
     * Updates/saves the details
     *
     * @param $request
     *
     */
    public function saveDetails($details)
    {
        if($this->hasDetails()) {
            $this->details->update([
                'description' => $details->description,
                'title' => $details->title
            ]);
        } else {
            Detail::insert([
                'inventory_id' => $this->id,
                'description' => $details->description,
                'title' => $details->title
            ]);
        }

        return true;
    }

    /**
     * Create new Item
     *
     * @param Request       $request
     *
     * @return Inventory    $item
     */
    public static function createNewItem($request)
    {
        $item = new Inventory;

        $item->metric_id = 1;
        $item->name = $request->name;
        $item->serialnr = $request->serialnr;
        $item->save();

        return $item;
    }

    public function hasPicture($pictureId)
	{
		return ! is_null(
			$this->pictures()
                 ->where('picture_id', $pictureId)
                 ->first()
		);
	}

    /**
     * Get Next and Previous Items of an Item
     *
     * @return Array
     */
    public function getNextPrev()
    {
        return (object) ['prev' => $this->previous(), 'next' => $this->next()];
    }

    private function next()
	{
		return Inventory::where('id', '>', $this->id)->orderBy('id', 'asc')->first();
	}


	private function previous()
	{
		return Inventory::where('id', '<', $this->id)->orderBy('id', 'desc')->first();
	}
}
