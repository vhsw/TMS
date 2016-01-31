<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends BaseModel
{
	public $timestamps = false;
   	protected $table = 'categories';
   	protected $guarded = ['id'];

   	public function tools()
    {
        return $this->hasMany('App\Models\Tool');
    }


    public static function getParentCategories($id)
   	{
   		$isparent = true;

   		$children = DB::table('categories')
        	->where('parent_id', '=', $id)
         	->get();

        if($children) {
        	$obj[] = array("id" => 0, "categories" => $children);
        }

   		while($isparent)
   		{
   			$category = Category::find($id);

   			$categories = DB::table('categories')
        	->where('parent_id', '=', $category->parent_id)
         	->get();

         	$obj[] = array("id" => $id, "categories" => $categories);

         	if(($category->parent_id == 0)) {
         		$isparent = false;
         	} else {
         		$id = $category->parent_id;
         	}
        }

        	return array_reverse($obj);
   	}


   	public static function buildCategoryData($rows, $parent=0)
    {
    	$sort = 0;

        foreach ($rows as $row)
        {
        	$sort = $sort+1;
            //echo "INSERT ".$this->sort." : ".$row->id.", parent_id(".$parent.") : ".$row->name."<br>";

            DB::table('categories')
                ->where('id', $row->id)
                ->update(['sort' => $sort, 'parent_id' => $parent]);

            if(isset($row->children))
            {
                Category::buildCategoryData($row->children, $row->id);   
            }
        }
    }

    public static function hasCategoryChildren($rows,$id) {
      foreach ($rows as $row) {
        if ($row->parent_id == $id)
          return true;
      }
      return false;
    }

    public static function buildCategoryMenu($rows,$parent=0)
    {  
      $result = '[';
      foreach ($rows as $row)
      {
        if ($row->parent_id == $parent){
          $result.= '{"name":"'.$row->name.'"';
          $result.= ',"id":'.$row->id;
          $result.= ',"parent_id":'.$row->parent_id;
          if (Category::hasCategoryChildren($rows,$row->id))
            $result.= ',"children":' .Category::buildCategoryMenu($rows,$row->id);
          $result.= '},';
        }
      }
      $result = rtrim($result, ",");
      $result.= "]";

      return $result;
    } 



}
