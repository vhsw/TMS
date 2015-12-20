<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Tool;


class LocationController extends Controller {

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

        $locations = DB::table('locations')->orderBy('location', 'asc')->get();

        return view('data.locations', compact('locations'));
    }

}