<?php namespace App\Services;

use \Carbon\Carbon;

class CustomDate {

	public static function formatTime($val)
	{
		return $val->format('d-m-Y H:i');		
	}

	public static function formatHuman($val)
	{
		$time = new Carbon($val);
		return Carbon::now()->diffForHumans($time->copy());		
	}

	public static function formatHistory($val)
	{
		$time = new Carbon($val);
		$now = Carbon::now();

		if ($time->isToday() == $now->isToday())	// Today
		{
			return 'Today at '.$val->format('H:i');
		}
		elseif ($time->isYesterday())	// Yesterday
		{
			return 'Yesterday at '.$val->format('H:i');
		}
		elseif ($time->format('Y') == $now->format('Y'))  	// If month
		{
			return $val->format('d M, H:i');
		}
		elseif ($time->format('Y') != $now->format('Y'))	// If year
		{
			return $val->format('d M Y, H:i');
		}
	}

	public static function thisMonth()
	{
		$now = Carbon::now();
		return $now->format('F');
	}
}