<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cost extends BaseModel
{
   	protected $table = 'costs';

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

   	public static function getLastCost($tool_id)
   	{
   		$cost = DB::table('costs')
        	->where('tool_id', '=', $tool_id)
        	->whereRaw('created_at = (SELECT MAX(created_at) FROM costs)')
         	->first();

        if ($cost) {
        	return $cost->cost;
        } else {
        	return false;
        }
   	}

}