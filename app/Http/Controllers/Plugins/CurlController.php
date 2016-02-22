<?php 

namespace App\Http\Controllers\Plugins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Tool;
use App\Models\Cost;
use App\Models\Supplier;
use App\Models\Category;
use HtmlDom;

class CurlController extends Controller {

	public $ch = null;
	public $supplier = null;

	public function __construct()
    {
 
    }

    public function index(Request $request)
    {
    	if ($request->ajax()) 
        { 
        	
	    	$this->ch = curl_init();
	    	curl_setopt($this->ch, CURLOPT_HEADER, true);
	        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
	        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);

	    	$supplier_id = $request->tool_info_supplier;
	    	$this->supplier = Supplier::find($supplier_id);

	    	if (method_exists($this, $this->supplier->shortname))
	    	{
	    		$fn = $this->supplier->shortname;
	    		$result = $this->$fn($request->searchstr, $fn);
	    	}

	    	curl_close($this->ch);

	    	return json_encode($result);
	    } else {
	    	return "Ajax error";
	    }
    }

    public function hoffmann($str, $fn)
    {
    	//prepare search string
    	$str = str_replace(' ', '-', $str);

    	curl_setopt($this->ch, CURLOPT_URL, 
    		"https://www.hoffmann-group.com/US/en/hus/search?type=product&search=".$str);

    	$output = curl_exec($this->ch);
        $info = curl_getinfo($this->ch);

        $html = new HtmlDom();
        $html->load($output);

        $title = $html->find('title', 0);
        if($title != null)
        {
        	$title = explode(' |', strip_tags($title))[0];
        }

        $imgs = $html->find('img[class=js-loupe]');
        $images = array();
        foreach($imgs as $img)
        {
        	array_push($images, $img->src);
        }

        $data = $html->find('img[class=img-nudge]', 0);
        if($data != null)
        {
        	$data = 'https://www.hoffmann-group.com'.$data->src;
        	array_push($images, $data);
        }

        $result = array(
        	'images' => $images,
        	'title1' =>	$title,
        	'title2' =>	null,
        	'cuttingdata' => null,
        	'description' => $html->find('div[class=block-readable]', 0)->innertext,
            'fn' => $fn
        );

        return $result;
    }
}