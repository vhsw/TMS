<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\System;


class SystemController extends Controller {

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
    public function systemvariables()
    {

        $systemvariables = System::all();

        return view('system.variables', compact('systemvariables'));
    }

}