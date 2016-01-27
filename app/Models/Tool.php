<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class User
 * @package App\Models\Access\User
 */
class Tool extends BaseModel 
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tools';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['password', 'remember_token'];

	/**
	 * For soft deletes
	 *
	 * @var array
	 */
	//protected $dates = ['deleted_at'];

	/**
	 * @return mixed
	 */

	public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function costs()
    {
        return $this->hasMany('App\Models\Cost');
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
        return $this->belongsToMany('App\Location', 'locations_tools');
    }

}
