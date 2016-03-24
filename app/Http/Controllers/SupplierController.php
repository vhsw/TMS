<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Supplier;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requests\CreateSupplierRequest;


class SupplierController extends Controller {

    public function __construct()
    {

    }


    public function index()
    {

        $suppliers = Supplier::all();

        return view('data.suppliers', compact('suppliers'));
    }

    /**
     * Get the possible Suppliers including the Items brand
     *
     * @param integer          $id
     *
     * @return json            Supplier
     */
    public function getPossibleSuppliers(Request $supplier)
    {
        return Supplier::getSuppliersByBrand($supplier->input('id'), true);
    }

    /**
     * Changes the Supplier for the Inventory Item
     *
     * @param Request          $supplier (Ajax)
     * @param Inventory        $item
     *
     * @return boolean
     */
    public function changeSupplier(Request $supplier, Inventory $item)
    {
        if ( $item->changeSupplierTo($supplier->input('id')) ) {
            return $this->getPossibleSuppliers($supplier);
        }

        return false;
    }


    public function create(Request $request)
    {
        if ( $request->producer == 'on' ) {
            $producer = 1;
            $supplied_by = $request->supplied_by;
        } else {
            $producer = 0;
            $supplied_by = 0;
        }

       $query = Supplier::create(array(
                'name' => $request->name,
                'producer' => $producer,
                'website' => $request->website,
                'phone' => $request->phone,
                'supplied_by' => $supplied_by
                ));
        //$id = $query->id;

        return redirect('admin/data/suppliers');
    }
}
