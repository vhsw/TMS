<?php 

namespace App\Http\Controllers;

use DB;
use App\Models\System;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requests\CreateSystemRequest;
use Illuminate\Database\Schema\Blueprint;


class SystemController extends Controller {

    public function __construct()
    {

    }


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