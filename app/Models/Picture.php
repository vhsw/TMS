<?php

namespace App\Models;

use DB;
use File;
use Storage;
use Illuminate\Database\Eloquent\Model;

class Picture extends BaseModel
{
	protected $table = 'pictures';

	protected $guarded = ['id'];

	public function inventories()
    {
        return $this->belongsToMany('App\Models\Inventory', 'pictures_inventories', 'picture_id')->withPivot('first_choice');
    }

	/**
     * Save Temporary Pictures that was Curled from supplier website
	 *
	 * @param $url
     *
     * @return $file
     */
	public static function saveTempPicture($url)
	{
		$file = basename($url);
		$content = file_get_contents($url);
		Storage::disk('temp')->put($file, $content);

		return $file;
	}

	/**
     * Save Images from temporary folder to Storage and store it in database
	 *
	 * @param Item		$item
	 * @param Supplier	$supplier
	 * @param array		$images
     *
     * @return
     */
	public static function saveImages($item, $supplier, $request)
    {
		// Get the short name of supplier
		$supplier = $supplier->shortname;
		$path = 'pictures/'.$supplier.'/';

		foreach ($request->images['image'] as $image)
		{
			$picture = Picture::where('path', '=', $path.$image)->first();
			$first_choice = ($request->picture == $image) ? 1 : 0;

			// If Picture exist in database, check if it's attached to this Item.
			// If Picture don't exist in database, create it and attach it to this Item.
			if($picture === null){
				$picture = new Picture(['path' => $path, 'title' => $image]);
				$picture->save();
				$picture->moveImage();
				$item->pictures()->attach($picture->id, ['first_choice' => $first_choice]);
			} elseif($picture) {

				// If item don't have picture attached, attach it!
				if( !$item->hasPicture($picture->id) ) {
					$item->pictures()->attach($picture->id);
				}
			}
		}
	}

	/**
     * Moves Image from Temporary Folder to Destination Folder, and creates
	 * recursive directory to destination if it don't exist.
     *
     * @return true
     */
	public function moveImage()
	{
		$path = $this->path;
		$from = public_path('temp').'\\'.basename($this->title);
		$to = 	public_path('files').'\\'.$path;

		// If directory don't exist, create it recursively
		if (!File::exists($to)){
			File::makeDirectory($to, 0777, true);
		}

		// Move temporary file to storage
		File::move($from, $to.basename($this->title));

		return true;
	}
}
