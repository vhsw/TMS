<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Http\Requests\Frontend\Tool\SearchToolRequest;
use TomLingham\Searchy\Facades\Searchy as Searchy;
use App\Models\Tool;
use App\Models\Cost;
use App\Models\Supplier;
use App\Models\Category;
use App\Services\AjaxTable;



class ToolController extends Controller {

    protected $orders;

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
        return view('tool.index');
    }

    public function db(Request $request)
    {
        if ($request->ajax()) 
        {  
            $tools = new AjaxTable($request);
            $tools->select('tools', array('serialnr', 'barcode'));
            $tools->with('categories', array('id', 'name'), 'category', 'category_id');
            $tools->with('suppliers', array('name'), 'supplier', 'supplier_id');

            return $tools->get();
        } else 
        {}
        
    }


    // TODO: Speed Up to less then 100ms, put it outside 
    public function typeahead(Request $request)
    {
        if ($request->ajax()) 
        {  
            $results = array();

            $tools = DB::table('tools')
                ->select('serialnr')
                ->where('serialnr', 'like', '%'.$request->input("query").'%')
                ->orderBy('serialnr', 'desc')
                ->get();

            foreach($tools as $tool) {
              $results[] =  $tool->serialnr;
            }

            return json_encode($results);
        }
    }

    public function barcode(Request $request)
    {
        if ($request->ajax()) 
        {  
            $query = rtrim($request->input("query"), ")");
            $query = trim($query, "(");

            $tool = Tool::with('supplier', 'category')->where('barcode', $query)->get();
            return json_encode($tool);
        }
    }


    public function search()
    {
        return view('tool.search');
    }

    public function browse()
    {

        $categories = DB::table('categories')->orderBy('sort', 'asc')->get();
        $accordion = $this->build_menu($categories);

        return view('tool.browse', compact('accordion'));
    }


    public function result(Request $request)
    {
       $this->validate($request, [
        'term' => 'required',
        ]);

            $term = $request->term;
            $currentPage = $request->get('page', 1);

            $max = 10;
            $from = $currentPage * $max - $max;
            $to = $max;

            $query = Searchy::search('tools')->fields('serialnr')->query($request->term)->getQuery();

            $total = count($query->get());

            $result = $query->limit($max)->offset($from)->get();


            $paginator = new LengthAwarePaginator($result, $total, $max, $currentPage);
            $paginator->setPath('result');

            return view('tool.search', compact('result', 'term', 'currentPage', 'total', 'max', 'paginator'));
    }

    public function view($id)
    {
        $tool = Tool::where('id', $id)->first();

        return view('tool.view', compact('tool'));
    }


    public function edit($id)
    {
        $tool = Tool::where('id', $id)->first();
        $suppliers = Supplier::all();
        $categories = Category::getParentCategories($tool->category_id);
        $costs = Cost::where("tool_id", "=", $id)->orderBy('supplier_id', "asc")->orderBy('updated_at', "desc")->get();

        return view('tool.edit', compact('tool', 'categories', "suppliers", "costs"));
    }


    public function request()
    {
        return view('tool.request');
    }


    public function save(Request $request, $id)
    {
        // Get Category Id
        $i=0;
        while($request->has("cat-".$i))
        {
            $i++;
        }
        $i--;

        if($request->input("cat-".$i) == 0) {
            $category_id = $request->input("cat-".($i-1));
        } else {
            $category_id = $request->input("cat-".($i));
        }


        $tool = Tool::find($id);
        $tool->serialnr = $request->serialnr;
        $tool->name0 = $request->name0;
        $tool->name1 = $request->name1;
        $tool->barcode = $request->barcode;
        $tool->supplier_id = $request->supplier_id;
        $tool->category_id = $category_id;
        $tool->save();

        return redirect('tool/'.($id + 1).'/edit');
    }








//########### BUILD CATEGORY MENU ################//

    public function build_data($rows, $parent=0)
    {
        foreach ($rows as $row)
        {
            $this->sort = $this->sort+1;
            echo "INSERT ".$this->sort." : ".$row->id.", parent_id(".$parent.") : ".$row->name."<br>";

            DB::table('categories')
                ->where('id', $row->id)
                ->update(['sort' => $this->sort, 'parent_id' => $parent]);

            if(isset($row->children))
            {
                $this->build_data($row->children, $row->id);   
            }
        }
    }

    public function has_children($rows,$id) {
      foreach ($rows as $row) {
        if ($row->parent_id == $id)
          return true;
      }
      return false;
    }

    public function build_menu($rows,$parent=0)
    {  
      $result = '<ul data-height="505" style="width:100%" class="menu-trigger accordion-menu" data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">';
      foreach ($rows as $row)
      {
        $nav_toggle = '';
        $span = '';
        if ($this->has_children($rows,$row->id)) 
        {
            $nav_toggle = 'nav-toggle';
            $span = '<span class="arrow "></span></a>';
        }

        if ($row->icon != "") 
        {
            $icon = '<img src="http://tms.local/assets/ICO/'.$row->icon.'.png">';
        } else
        {
            $icon = '<i class=" icon-plus"></i>';
        }

        if ($row->parent_id == $parent){
          $result.= '<li id="category-'.$row->id.'" class="nav-item"><a href="javascript:;" class="nav-link '.$nav_toggle.'">'
                    .$icon.'<span class="title"> '.$row->name.'</span>'.$span;

          if ($this->has_children($rows,$row->id))
            $result.= $this->build_submenu($rows,$row->id);
          $result.= '</li>';
        }
      }
      //$result = rtrim($result, ",");
      $result.= "</ul>";

      return $result;
    }

    public function build_submenu($rows,$parent=0)
    {  
      $result = '<ul class="sub-menu">';
      foreach ($rows as $row)
      {
        $nav_toggle = '';
        $span = '';
        if ($this->has_children($rows,$row->id)) 
        {
            $nav_toggle = 'nav-toggle';
            $span = '<span class="arrow "></span></a>';
        }

        if ($row->icon != "") 
        {
            $icon = '<img src="http://tms.local/assets/ICO/'.$row->icon.'.png">';
        } else
        {
            $icon = '<i class=" icon-plus"></i>';
        }

        if ($row->parent_id == $parent){
          $result.= '<li id="category-'.$row->id.'" class="nav-item start "><a href="javascript:;" class="nav-link '.$nav_toggle.'">'
                    .$icon.'<span class="title"> '.$row->name.'</span>'.$span;

          if ($this->has_children($rows,$row->id))
            $result.= $this->build_submenu($rows,$row->id);
          $result.= '</li>';
        }
      }
      //$result = rtrim($result, ",");
      $result.= "</ul>";

      return $result;
    }
}
