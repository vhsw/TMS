<?php 

namespace App\Http\Controllers;

use DB;
use App\Models\System;
use App\Models\Notification;
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

        $budget = DB::table('statistic_expenses')->where('year', date('Y'))->get();
        
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
       if( !System::hasBudget(date('Y')) ) {
            System::newBudget($request->budget);
       } else {
            System::updateBudget($request->budget);
       }
    }

    public function setAsRead(Request $request)
    {
        Notification::where('id', $request['id'])->update(['is_read' => 1]);

        return "Set notification nr ".$request['id']." as read.";
    }
}