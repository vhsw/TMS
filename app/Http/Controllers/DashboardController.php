<?php 

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Models\Tool;
use App\Models\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends Controller {

	public function index()
	{
		// Monday this week
		$last_monday = date('Y-m-d H:i:s', strtotime("last monday"));

		// Requests this week
		$requests = Requests::where( 'created_at', '>', $last_monday )->get();

		// Total Cost this Week
		$totals = DB::table('requests')
			->select(DB::raw('FORMAT(SUM(amount * cost), 2) total'))
			->where('created_at', '>', $last_monday)
			->get();

		$sum = 0;
		foreach($totals[0] as $total)
		{
			$sum = $sum + str_replace(',', '', $total);
		}

		if (Auth::check())
		{
			$user = User::find(Auth::user()->id);
			$notifications = $user->notifications()->unread()->get();
			return view('index', compact('requests', 'last_monday', 'sum', 'user', 'notifications'));
		} else
		{
			return view('index', compact('requests', 'last_monday', 'sum'));
		}
	}

	public function test()
	{
		$result = Tool::find(1)->getTotalStock();
		return view('test', compact('result'));
	}
}