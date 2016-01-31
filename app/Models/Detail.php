<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detail extends BaseModel 
{

	protected $table = 'details';

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

	public function tool()
    {
        return $this->belongsTo('App\Models\Tool');
    }
}
