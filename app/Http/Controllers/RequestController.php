<?php 

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Models\Cost;
use App\Models\Tool;
use App\Models\System;
use App\Models\Supplier;
use App\Models\Requests;
use App\Helpers\CustomDate;
use App\Services\AjaxTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use TomLingham\Searchy\Facades\Searchy as Searchy;
use App\Http\Requests\Frontend\CreateRequestsRequest;

class RequestController extends Controller {

    public function __construct()
    {
    }


    public function index()
    {
        return view('request.index');
    }


    public function db(Request $request)
    {
        if ($request->ajax()) 
        {  
            $requests = new AjaxTable($request);
            $requests->select('requests', array('id', 'description', 'tool_serialnr', 'tool_id', 'amount', 'comments', 'status', 'cost', 'updated_at'));
            $requests->with('users', array('name'), 'user', 'user_id');

            return $requests->get();
        } else 
        {

        }
        
    }


    public function request()
    {
        return view('request.new');
    }


    public function create(Request $request)
    {
        if($request->serialnr) // If Requested from Request Page
        {
            $tool = Tool::where('serialnr', $request->serialnr)->first();
            if(isset($tool))
            { 
                $tool_id = $tool->id;
                $barcode = $tool->barcode;
                $cost = Cost::getLastCost($tool->id);
            }
            else 
            { 
                $tool_id = ""; 
                $barcode = "";
                $cost = "0.00";
            }
            $serialnr = $request->serialnr;
            $description = $request->description;
        }
        elseif($request->search_str) // If Requested from Search Overlay
        {
            $search_str = trim($request->search_str, "(..)"); // Clean barcode
            $tool = Tool::where('barcode', $search_str)->first();
            $tool_id = $tool->id;
            $barcode = $search_str;
            $serialnr = $tool->serialnr;
            $description = "";
        }

       $newRequest = Requests::create(array(
                'description' => $description,
                'tool_serialnr' => $serialnr,
                'barcode' => $barcode,
                'tool_id' => $tool_id,
                'user_id' => auth()->user()->id,
                'amount' => $request->amount,
                'cost' => $cost,
                'comments' => "",
                'status' => "REQUESTED"
                ));
        $id = $newRequest->id;

        $user = User::find(1);
        $user->newNotification()->withType('Request')->withBody('was requested')
             ->regarding($newRequest)->deliver();

        return redirect('requests');
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
        if($request->status == "ORDERED" && $tool_id != "") {

            $lastCost = Cost::getLastCost($tool_id);

            // If new price, add to cost table
            if($lastCost != $cost) {
                $costRow = new Cost;
                $costRow->tool_id = $tool_id;
                $costRow->supplier_id = $request->supplier_id;
                $costRow->cost = $cost;
                $costRow->save();
            }
            System::addExpense($cost); // Update the Expense Statistic
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