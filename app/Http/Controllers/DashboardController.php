<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use App\User;
use App\Models\Requests;
use App\Models\Tool;
use DB;
use Auth;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class DashboardController extends BaseController {

	/**
	 * @return \Illuminate\View\View
	 */
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
			$user = User::find(auth()->user()->id);
			$notifications = $user->notifications()->unread()->get();
			return view('index', compact('requests', 'last_monday', 'sum', 'user', 'notifications'));
		} else
		{
			return view('index', compact('requests', 'last_monday', 'sum'));
		}
	}
}