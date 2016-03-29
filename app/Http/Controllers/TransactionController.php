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
        $request->receivedAll( 'recieved', $request->stock->item->getCurrentSupplierCost() );

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
        // If quantity has changed and the transaction has the state of Request, update the quantity
        if ($transaction->original_quantity <> $request->quantity && $transaction->isRequest()) {
            $transaction->changeQuantityTo($request->quantity);
        }

        $currentSupplier = $transaction->stock->item->getCurrentSupplierPivot();

        // If supplier or cost have changed, add new Cost.
        if ($currentSupplier->cost != $request->cost || $currentSupplier->supplier_id != $request->supplier_id) {
            $transaction->addCost($request->cost, $request->supplier_id);
        }

        $transaction->comments = $request->comments;
        $transaction->save();
    }


    public function delete($id)
    {
        Requests::destroy($id);
        return redirect('requests');
    }
}
