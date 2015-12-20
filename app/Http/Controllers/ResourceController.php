<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Resource;
use App\User;
use App\Services\AjaxTable;


class ResourceController extends Controller {

    /**
     * Instantiate a new UserController
     */
    public function __construct()
    {
        //\View::share('generals', Generals::getAll());
    }


    public function index()
    {
        return view('data.resources');
    }

    public function db(Request $request)
    {
        if ($request->ajax()) 
        {  
            $resources = new AjaxTable($request);
            $resources->select('resources', array('name', 'short_name', 'controller'));

            return $resources->get();
        }
        else
        {
           
        }
    }


    public function select(Request $request)
    {
        if ($request->ajax()) 
        {               
            $user = User::find(Auth::user()->id);
            $user->resource_id = $request->resource;
            $user->save();

            return response()->json(['value' => 'Changed machine to:' . $request->resource]);
        } 
        else
        {
            return response()->json(['error' => 'RequestController@select : No Ajax']);
        }
    }

}