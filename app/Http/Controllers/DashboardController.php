<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Models\Tool;
use App\Models\Picture;
use App\Models\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends Controller {

	public function index()
	{
		// Monday this week
		$last_monday = date('Y-m-d H:i:s', strtotime("last monday"));

		// Requests this week
		//$requests = Requests::where( 'created_at', '>', $last_monday )->get();

		/* Total Cost this Week
		$totals = DB::table('requests')
			->select(DB::raw('FORMAT(SUM(amount * cost), 2) total'))
			->where('created_at', '>', $last_monday)
			->get();*/

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
		\App\Services\ImageCrop::image('https://static.hoffmann-group.com/medias/sys_master/root/haf/he6/8870973440030/b122380-ha-k39.jpg');
		//return view('test', compact('result'));
	}
}
