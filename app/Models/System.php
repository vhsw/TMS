<?php namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models\Access\User
 */
class System extends BaseModel {

	protected $table = 'system';

	protected $casts = [
        'content' => 'array',
    ];


    public static function updateBudget($budget)
    {
    	$yearColumn = '_'.date('Y');

    	for($i = 0; $i < 12; $i++)
    	{
    		DB::table('budget')->where('id', $i + 1)->update([ $yearColumn => $budget[$i] ]);
    	}
    }
}
