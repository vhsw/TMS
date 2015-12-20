<?php namespace App\Services;


class Metronic {

	public static function classStatus($val)
	{
		switch($val){
			case 'REST': $class = "label-warning"; break;
			case 'REQUESTED': $class = "label-danger"; break;
			case 'ORDERED': $class = "label-info"; break;
			case 'RECIEVED': $class = "label-success"; break;
		}	

		return $class;
	}

}