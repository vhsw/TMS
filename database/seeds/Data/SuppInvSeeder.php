<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\Supplier;

class SuppInvSeeder extends Seeder {

    public function run() {

        DB::table('inventory_suppliers')->delete();

        $supplier = Supplier::find(1);

        $items = Inventory::all();

        foreach($items as $item)
        {
            $item->addSupplier($supplier);
        }

    }
}
