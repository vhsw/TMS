<?php 

namespace App\Models;

use DB;
use App\Http\Traits\InventoryTrait;
use Illuminate\Database\Eloquent\Model;

class Tool extends BaseModel 
{
    use InventoryTrait;

	protected $table = 'tools';

	protected $guarded = ['id'];


	public static function next($tool_id)
	{
		return DB::select('SELECT id FROM tools WHERE id > '.$tool_id.' ORDER BY id ASC LIMIT 1');
	}


	public static function previous($tool_id)
	{
		return DB::select('SELECT id FROM tools WHERE id < '.$tool_id.' ORDER BY id DESC LIMIT 1');
	}


    public function scopePreferredToolPicture()
    {
        return $this->getPreferredToolPicture();
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


    public function stocks()
    {
        return $this->belongsToMany('App\Models\Location', 'stock_connections', 'tool_id', 'id')->withPivot('quantity');;
    }
}
