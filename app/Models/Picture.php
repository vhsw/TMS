<?php 

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Picture extends BaseModel 
{
	protected $table = 'pictures';

	protected $guarded = ['id'];

	public function tools()
    {
        return $this->belongsToMany('App\Models\Tool', 'pictures_tools')->withPivot('first_choice');
    }
}
