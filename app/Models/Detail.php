<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detail extends BaseModel 
{

	protected $table = 'details';

	protected $guarded = ['id'];

	public function tool()
    {
        return $this->belongsTo('App\Models\Tool');
    }

    public static function saveDetails($id, $data)
    {
    	Detail::create(array(
            'tool_id' => $id,
            'title1' => $data['title1'],
            'title2' => $data['title2'],
            'cuttingdata' => $data['cuttingdata'],
            'description' => $data['description']
        ));
    }
}
