<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Models\Cost;
use App\Models\Tool;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Requests;
use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\InventoryTransaction;
use App\Services\AjaxTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use TomLingham\Searchy\Facades\Searchy as Searchy;
use App\Http\Requests\Frontend\CreateRequestsRequest;

class TransactionController extends Controller {

    public function __construct()
    {
    }


    public function index()
    {
        return view('transaction.index');
    }


    public function db(Request $request)
    {
        if ($request->ajax())
        {
            $requests = new AjaxTable($request);
            $requests->select('inventory_transactions', array('id', 'state', 'original_quantity', 'updated_at'));
            $requests->with('inventory_stocks', array('inventory_id', 'user_id'), 'id', 'inventory_transactions', 'stock_id');
            $requests->with('users', array('name'), 'id', 'inventory_stocks', 'user_id');
            $requests->with('inventories', array('name', 'serialnr'), 'id', 'inventory_stocks', 'inventory_id');
            //$requests->with('inventory_transaction_histories', array('quantity_before'), 'id', 'inventory_stocks', 'inventory_id');
            //$requests->with('users', array('name'), 'user', 'user_id');


            return $requests->get();
        } else
        {

        }

    }

    /**
     * Create Request of inventory item
     *
     * @param Request      $request
     *
     * @return array
     */
    public function request(Request $request)
    {
        $item = Inventory::where('serialnr', $request->serialnr)->first();

        // If no item was found in database, create it.
        if (count($item) < 1) {
            $item = Inventory::createNewItem($request);
        }

        $stock = InventoryStock::where('inventory_id', $item->id)->where('location_id', 1)->first();

        // If no stock was found in database, create one.
        if (count($stock) < 1) {
            $stock = InventoryStock::createEmptyStock($item);
        }

        // create a request transaction
        $transaction = $stock->newTransaction();
        $transaction->requested($request->quantity);

        echo $transaction;
    }

    /**
     * Cancel the specified Request Transaction
     *
     * @param InventoryTransaction      $request
     *
     * @return array
     */
    public function cancel(InventoryTransaction $request)
    {
        $request->cancel();

        return $request;
    }

    /**
     * Order the Requested transaction
     *
     * @param InventoryTransaction      $request
     *
     * @return array
     */
    public function order(InventoryTransaction $request)
    {
        $cost = $request->stock->item->getCurrentSupplierCost();
        $request->ordered($request->quantity);

        return $request;
    }

    /**
     * Recieve the Ordered transaction
     *
     * @param InventoryTransaction      $request
     *
     * @return array
     */
    public function receive(InventoryTransaction $request)
    {
        $request->received();

        return $request;
    }

    /**
     * Create Request of inventory item
     *
     * @param Request      $request
     *
     * @return array
     */
     public function edit(InventoryTransaction $request)
     {
         $suppliers = Supplier::getMainSuppliers();

         return view('transaction.edit', compact('request', 'suppliers'));
     }


    public function save(InventoryTransaction $transaction, Request $request)
    {
        $currentSupplier = $transaction->stock->item->getCurrentSupplierPivot();

        // Check if supplier or cost have changed and add new Cost.
        if ($currentSupplier->cost != $request->cost || $currentSupplier->supplier_id != $request->supplier_id) {
            $transaction->addCost($request->cost, $request->supplier_id);
        }

        return 'true';
    }


    public function delete($id)
    {
        Requests::destroy($id);
        return redirect('requests');
    }
}
