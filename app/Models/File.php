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

	public static function getImagesByObject($object_type, $object_id)
	{
		$files = DB::table('objects_files')
                    ->select('file_id')
                    ->where('object_id', $object_id)
                    ->where('object_type', $object_type)->get();
        $collection = collect($files);
        $file_ids = $collection->pluck('file_id');
        $images = File::whereIn('id', $file_ids)->whereIn('file_type', ['jpg', 'png', 'gif']);
        return $images;
    }
}
