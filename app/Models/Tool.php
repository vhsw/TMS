<?php 

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Tool extends BaseModel 
{
	protected $table = 'tools';

	protected $guarded = ['id'];


    /**
     * Get the total quantity stored by one tool.
     *
     * @param int              $tool_id
     *
     * @return int
     */
	public static function getStockQuantity($tool_id)
	{
		$result = DB::select( DB::raw('SELECT a.new_quantity
                FROM locations_tools a WHERE EXISTS(
                    SELECT 1 FROM
                        (SELECT id, new_quantity, location_id, max(updated_at) AS updated_at FROM locations_tools GROUP BY location_id)b 
                            WHERE b.location_id = a.location_id AND b.updated_at = a.updated_at
                        ) AND tool_id ='.$tool_id));

        $collection = collect($result);

        return $collection->pluck('new_quantity')->sum();
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

    public function barcode()
    {
        return $this->hasOne('App\Models\Barcode');
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
