<?php 

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Barcode extends BaseModel 
{

	protected $table = 'barcodes';

	protected $guarded = ['id'];


	public function tool()
    {
        return $this->belongsTo('App\Models\Tool');
    }
}
