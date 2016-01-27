<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\Metronic;


class CategoryController extends Controller {

    public $nested = "";
    public $sort = 0;
    public $result = "";
    /**
     * Instantiate a new UserController
     */
    public function __construct()
    {
        //\View::share('generals', Generals::getAll());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $categories = DB::table('categories')->orderBy('sort', 'asc')->get();
        $json = Category::buildCategoryMenu($categories);

        return view('data.categories', compact('categories', 'json'));
    }

    public function save(Request $request)
    {
        $json = json_decode($request->json);

        Category::buildCategorydata($json);

        return redirect('admin/data/categories')->with('flash_success', 'Categories Updated Successfully!');
    }

    public function tree(Request $request)
    {
        $categories = Category::getParentCategories($request->id);
        return $categories;
    }

    public function children(Request $request)
    {
        $categories = Category::where('parent_id', $request->id)->get();

        $this->result = $request->id;
        //$this->build_children($categories, $request->id);

        return $this->result;
    }







    // Get all children and sub children of clicked category menu item.
    public function build_children($rows, $parent)
    {  

      foreach ($rows as $row)
      {
            $children = null;
            $this->result = $this->result . "|" . $row->id;

            $children = Category::where('parent_id', '=', $row->id)->get();

            if (count($children) > 0) 
            {
                $this->result .= $this->build_children($children, $row->id);
            }
        }
    }

}