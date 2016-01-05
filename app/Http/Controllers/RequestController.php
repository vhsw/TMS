<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Frontend\CreateRequestsRequest;
use TomLingham\Searchy\Facades\Searchy as Searchy;
use App\Helpers\CustomDate;
use App\Models\Tool;
use App\User;
use App\Models\Requests;
use App\Models\System;
use App\Models\Supplier;
use App\Services\AjaxTable;
use App\Models\Cost;


class RequestController extends Controller {


    /**
     * Instantiate a new UserController
     */
    public function __construct()
    {
        //\View::share('generals', Generals::getAll());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$requests = Requests::all();


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
        {}
        
    }


    public function request()
    {
        return view('request.new');
    }


    public function create(Request $request)
    {
        if($request->serialnr)
            $tool = Tool::where('serialnr', $request->serialnr)->first();

        if(isset($tool))
        { 
            $tool_id = $tool->id;
            $barcode = $tool->barcode;
        }
        else 
        { 
            $tool_id = ""; 
            $barcode = "";
        }
        
       $newRequest = Requests::create(array(
                'description' => $request->description,
                'tool_serialnr' => $request->serialnr,
                'barcode' => $barcode,
                'tool_id' => $tool_id,
                'user_id' => auth()->user()->id,
                'amount' => $request->amount,
                'comments' => "",
                'status' => "REQUESTED"
                ));
        $id = $newRequest->id;

        $user = User::find(1);
        $user->newNotification()->withType('Request')->withBody('New Request has been added')
             ->regarding($newRequest)->deliver();

        return redirect('tools/requests');
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

            return redirect('tools/requests');
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
                $costRow->cost = $cost;
                $costRow->save();
            }
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
            $user->newNotification()->withType('Request')->withBody('Your Request has been ordered')
                ->regarding($item)->deliver();
        } elseif($request->status == "RECIEVED") {
            $user->newNotification()->withType('Request')->withBody('Your Request has been recieved')
                ->regarding($item)->deliver();
        }

        $item->save();
        return redirect('tools/requests');
    }


    public function delete($id)
    {
        Requests::destroy($id);
        return redirect('tools/requests');
    }
    

}
