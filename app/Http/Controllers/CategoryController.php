<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Category;
use App\Services\Metronic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller {

    public $nested = "";
    public $sort = 0;
    public $result = "";


    public function __construct()
    {

    }


    public function index()
    {
        $categories = Category::all()->toHierarchy();

        return view('data.categories', compact('categories'));
    }


    public function getImmediateDescendants(Request $request)
    {
        $category = Category::find($request->id);

        if($category) {
            return json_encode( $category->getImmediateDescendants() );
        }
    }


    public function generateSelectBoxes(Request $request)
    {
        $roots = Category::find($request->id)->getAncestorsAndSelf();

        if($roots) {
            $result = array();

            foreach($roots as $root)
            {
                $result[] = $root->getImmediateDescendants();
            }
            return $result;
        }
    }


    public function save(Request $request)
    {
        //$json = json_decode($request->json);

        //Category::buildCategorydata($json);

        //return redirect('admin/data/categories')->with('flash_success', 'Categories Updated Successfully!');
    }

}
