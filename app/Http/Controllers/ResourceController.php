<?php 

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Models\Resource;
use App\Services\AjaxTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ResourceController extends Controller {

    public function __construct()
    {

    }


    public function index()
    {
        $locations = DB::table('resources')->orderBy('name', 'asc')->get();

        return view('data.resources', compact('resources'));
    }

    
    public function change(Request $request)
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