<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\Metronic;


class CategoryController extends Controller {

    public $nested = "";
    public $sort = 0;
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

}