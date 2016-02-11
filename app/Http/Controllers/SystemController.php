<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\Models\System;
use DB;
use App\Requests\CreateSystemRequest;


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

        $budget = null;
        if(\Schema::hasColumn('budget', '_'.date('Y'))) 
        {
            $budget = DB::table('budget')->get();
        }

        return view('system.variables', compact('systemvariables', 'budget'));
    }


    public function update()
    {
        return view('system.update');
    }


    public function save(Request $request)
    {
        $this->handleBudget($request);
    }


    private static function handleBudget($request)
    {
        if(!\Schema::hasColumn('budget', '_'.date('Y'))) 
        {
            \Schema::table('budget', function ($table) {
                $table->decimal('_'.date('Y'), 8, 2);
            });
        }

        System::updateBudget($request->budget);
    }

}