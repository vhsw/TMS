<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends BaseModel
{
	public $timestamps = false;
   	protected $table = 'locations';


   	public function tools()
    {
        return $this->belongsToMany('App\Models\Tool', 'locations_tools');
    }

}
