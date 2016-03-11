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
        // Create Location
        //$location = new Location;
        //$location->name = 'Supplier';
        //$location->save();

        return view('transaction.index');
    }


    public function db(Request $request)
    {
        if ($request->ajax())
        {
            $requests = new AjaxTable($request);
            $requests->select('inventory_transactions', array('id', 'state', 'quantity', 'updated_at'));
            $requests->with('inventory_stocks', array('inventory_id', 'user_id'), 'id', 'inventory_transactions', 'stock_id');
            $requests->with('users', array('name'), 'id', 'inventory_stocks', 'user_id');
            $requests->with('inventories', array('name', 'serialnr'), 'id', 'inventory_stocks', 'inventory_id');
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
        $request->received();

        return $request;
    }


    public function edit($id)
    {
        if($id)
        {
            // Set the proper status
            $request = Requests::find($id);
            $suppliers = Supplier::all();
            $request_status = array();

            if ($request->status == "ORDERED")
            {
                array_push($request_status, "ORDERED", "RECIEVED", "REST");
            }
            elseif($request->status == "RECIEVED" || $request->status == "REST")
            {
                array_push($request_status, "RECIEVED");
            }
            elseif($request->status == "REQUESTED")
            {
                array_push($request_status, "ORDERED", "REQUESTED");
            }
            else
            {
                array_push($request_status, "REST", "ORDERED", "REQUESTED", "RECIEVED");
            }

            return view('request.edit', compact('request', 'request_status', 'suppliers'));
        }
        else {

            return redirect('requests');
        }
    }


    public function save(Request $request, $id)
    {

        if($request->tool_serialnr)
            $tool = Tool::where('serialnr', $request->tool_serialnr)->first();

        // Format Tool
        if(isset($tool)) {
            $tool_id = $tool->id;
            $barcode = $tool->barcode;
        } else {
            $tool_id = "";
            $barcode = $request->barcode;
        }

        /** Format Cost **/
        if($request->cost) {
            $cost = $request->cost; //str_replace(',', '', substr($request->cost, 4));
        } else {
            $cost = '0.00';
        }

        // If Status changed to ORDERED
        if($request->status == "ORDERED") {

            if ($tool_id != "") {
                $lastCost = Cost::getLastCost($tool_id);

                // If new price, add to cost table
                if($lastCost != $cost) {
                    $costRow = new Cost;
                    $costRow->tool_id = $tool_id;
                    $costRow->supplier_id = $request->supplier_id;
                    $costRow->cost = $cost;
                    $costRow->save();
                }
            }

            System::addExpense($cost * $request->amount); // Update the Expense Statistic
        }

        //return view('test', compact('cost'));

        $item = Requests::find($id);

        $item->description = $request->description;
        $item->tool_serialnr = $request->tool_serialnr;
        $item->barcode = $barcode;
        $item->tool_id = $tool_id;
        $item->amount = $request->amount;
        $item->comments = $request->comments;
        $item->status = $request->status;
        $item->cost = $cost;

        $user = User::find($item->user_id);
        if($request->status == "ORDERED") {
            $user->newNotification()->withType('Request')->withBody('has been ordered')
                ->regarding($item)->deliver();
        } elseif($request->status == "RECIEVED") {
            $user->newNotification()->withType('Request')->withBody('has been recieved')
                ->regarding($item)->deliver();
        }

        $item->save();
        return redirect('requests');
    }


    public function delete($id)
    {
        Requests::destroy($id);
        return redirect('requests');
    }
}
