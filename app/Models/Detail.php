<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Detail extends BaseModel
{

	protected $table = 'details';

	protected $guarded = ['id'];


	public function inventory()
    {
        return $this->belongsTo('App\Models\Invetory');
    }

	
}
