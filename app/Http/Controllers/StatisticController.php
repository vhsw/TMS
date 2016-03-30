<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Models\Tool;
use App\Models\Requests;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

class StatisticController extends Controller {

	public function chartBudget()
	{
        $expenses = DB::table('statistic_expenses')->where('year', date('Y'))->get();

        // Create JSON
        $data = '[';
        $futureMonth = '';
        $nextMonth = date('n') + 1;
        $p = false;
        foreach($expenses as $expense)
        {
            $monthName = date("F", mktime(null, null, null, $expense->month));

            if(($nextMonth == $expense->month) && ($p == false)) {
                    $futureMonth = ', "dashLengthColumn": 5,"alpha": 0.2,"additional": "(projection)"';
                    $p = true;
            }

            $data .= '{"month": "'.$monthName.'", "budget": '.$expense->budget.', "cost": '.$expense->cost . $futureMonth. '},';
        }
        $data = substr($data, 0, -1);
        $data .= ']';

        header('Content-type: application/json');
        echo $data;
	}

	public function chartTotalInventoryPerSupplier()
	{
		$suppliers = Supplier::getMainSuppliers();

		$data = '[';
		foreach($suppliers as $supplier)
		{
			$data .= '{"supplier": "'.$supplier->name.'", "value": '.$supplier->getTotalInventoryValue().', "color": "#FF6600"},';
		}
		$data = substr($data, 0, -1);
        $data .= ']';

		header('Content-type: application/json');
        echo $data;
	}
}
