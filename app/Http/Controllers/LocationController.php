<?php 

namespace App\Http\Controllers;

use DB;
use App\Models\Tool;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller {

    public function __construct()
    {
    }


    public function index()
    {

        $locations = DB::table('locations')->orderBy('location', 'asc')->get();

        return view('data.locations', compact('locations'));
    }
}