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
}
