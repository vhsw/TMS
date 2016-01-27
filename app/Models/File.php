<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class File extends BaseModel 
{

	protected $table = 'files';

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

}
