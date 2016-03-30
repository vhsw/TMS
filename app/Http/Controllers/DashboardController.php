<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Models\Tool;
use App\Models\Picture;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends Controller {

	public function index()
	{
		// Monday this week
		$last_monday = date('Y-m-d H:i:s', strtotime("last monday"));

		$sum = 0;
		/*foreach($totals[0] as $total)
		{
			$sum = $sum + str_replace(',', '', $total);
		}*/

		if (Auth::check())
		{
			$user = User::find(Auth::user()->id);
			//$notifications = $user->notifications()->unread()->get();
			return view('index', compact('user'));
		} else
		{
			return view('index', compact('last_monday'));
		}
	}

	public function test()
	{
		//$item = Inventory::find(1);

		$result = Inventory::find(1);

		echo json_encode($result->getTotalStockQuantity());

		dd($result);
		//return view('test', compact('result'));
	}
}
