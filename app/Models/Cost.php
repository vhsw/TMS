<?php 

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

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

    public static function getCosts($tool_id)
    {
        $costs = Cost::where("tool_id", "=", $tool_id)
          ->orderBy('supplier_id', "asc")
          ->orderBy('updated_at', "desc")
          ->get();

        return $costs;
    }
}