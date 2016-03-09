<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Barcode extends BaseModel
{

	protected $table = 'barcodes';

	protected $guarded = ['id'];

	protected $fillable = array(
        'inventory_id',
        'barcode',
    );

	public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id');
    }
}
