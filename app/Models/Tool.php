<?php 

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Tool extends BaseModel 
{
	protected $table = 'tools';

	protected $guarded = ['id'];


	public static function getStockAmount($tool_id)
	{
		$amount = DB::table('locations_tools')
            ->select('amount', DB::raw('SUM(amount) as amount'))
            ->where('tool_id', $tool_id)->first();

        return $amount;
	}


	public static function next($tool_id)
	{
		return DB::select('SELECT id FROM tools WHERE id > '.$tool_id.' ORDER BY id ASC LIMIT 1');
	}


	public static function previous($tool_id)
	{
		return DB::select('SELECT id FROM tools WHERE id < '.$tool_id.' ORDER BY id DESC LIMIT 1');
	}


	public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }


    public function costs()
    {
        return $this->hasMany('App\Models\Cost');
    }


    public function pictures()
    {
        return $this->belongsToMany('App\Models\Picture', 'pictures_tools')->withPivot('first_choice');
    }


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }


    public function details()
    {
        return $this->hasMany('App\Models\Detail');
    }


    public function locations()
    {
        return $this->belongsToMany('App\Models\Location', 'locations_tools');
    }
}
