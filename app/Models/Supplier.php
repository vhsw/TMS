<?php

namespace App\Models;

use App\Traits\SupplierTrait;

class Supplier extends BaseModel
{
    use SupplierTrait;

    protected $table = 'suppliers';

    public function items()
    {
        return $this->belongsToMany('App\Models\Inventory', 'inventory_suppliers', 'supplier_id')->withTimestamps();
    }

    public static function getSuppliersByBrand($id, $includeThis = false)
    {
        $instance = new static();
        $brand = $instance->find($id);

        // TODO: Make Brand able to have many Suppliers.
        $supplier = Supplier::where('id', $brand->supplied_by)->first();

        if($includeThis === true) {
            return array($supplier, $brand);
        }

        return array($supplier);
    }
}
