<?php 

namespace App\Http\Controllers;

use DB;
use HtmlDom;
use Storage;
use App\Models\Tool;
use App\Models\Cost;
use App\Models\File;
use App\Models\Detail;
use App\Models\Picture;
use App\Models\Supplier;
use App\Models\Category;
use App\Services\AjaxTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Frontend\User\UserContract;
use TomLingham\Searchy\Facades\Searchy as Searchy;
use App\Http\Requests\Frontend\Tool\SearchToolRequest;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;


class ToolController extends Controller {

    protected $orders;


    public function __construct()
    {

    }


    public function index()
    {
        return view('tool.index');
    }

    public function db(Request $request)
    {
        if ($request->ajax()) 
        {  
            $tools = new AjaxTable($request);
            $tools->select('tools', array('id', 'serialnr', 'barcode'));
            $tools->with('categories', array('id', 'name'), 'category', 'category_id');
            $tools->with('suppliers', array('name'), 'supplier', 'supplier_id');

            return $tools->get();

        } 
        else 
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

            $tool = Tool::with('supplier', 'category')->where('barcode', $query)->first();

            $locations = DB::table('locations_tools')->where('tool_id', $tool->id)
                ->join('locations', 'locations_tools.location_id', '=', 'locations.id')->get();

            $result = array(
                'locations' => $locations,
                'tool' => $tool
                );

            return json_encode($result);
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
        $result = $query->limit($max)->offset($from)->get();
        $total = count($query->get());

        $tools = array();
        foreach($result as $tool)
        {
            $tools[] = Tool::find($tool->id);
        }

        /*$result = $query->whereExists(function ($query) {
            $query->select(DB::raw(1))
            ->from('locations_tools')
            ->whereRaw('locations_tools.tool_id = tools.id')
            ->where('amount', '>', 0);
        })->limit($max)->offset($from)->get();*/

        $paginator = new LengthAwarePaginator($result, $total, $max, $currentPage);
        $paginator->setPath('result');

        return view('tool.search', compact('tools', 'term', 'currentPage', 'total', 'max', 'paginator'));
    }


    public function view($id)
    {
        // Get Tool Details
        $tool =     Tool::where('id', $id)->first();
        $detail =   Detail::where('tool_id', $tool->id)->first();
        $costs =    Cost::getCosts($tool->id);
        $amount =   Tool::getStockAmount($tool->id);

        // Get Category
        $category = $tool->category->name;
        $parent_id = $tool->category->parent_id;

        while ($parent_id > 0)
        {
            $cat = Category::find($parent_id);
            $category = $cat->name.' / '.$tool->category->name;
            $parent_id = $cat->parent_id;
        }

        return view('tool.view', compact('tool', 'detail', 'costs', 'category', 'amount'));
    }


    public function edit($id)
    {
        // Get Tool Details
        $tool =         Tool::where('id', $id)->first();
        $suppliers =    Supplier::all();
        $categories =   Category::getParentCategories($tool->category_id);
        $detail =       Detail::where('tool_id', '=', $tool->id)->first();
        $costs =        Cost::getCosts($tool->id);

        // Create Navigation for Next and Previous Tool
        $navigate = $this->makeNextPrev($tool->id);

        return view('tool.edit', compact('tool', 'categories', 'suppliers', 'costs', 'navigate', 'detail'));
    }


    private function makeNextPrev($tool_id)
    {
        $prev = Tool::previous($tool_id);
        $next = Tool::next($tool_id);

        if (!$prev) { $prev = false; } else { $prev = $prev[0]->id; }
        if (!$next) { $next = false; } else { $next = $next[0]->id; }

        return ['prev' => $prev, 'next' => $next];
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

        $next = Tool::next($tool->id);
        if (!$next) 
        { 
            return redirect('tool/'.$id.'/edit'); 
        } 
        else 
        { 
            return redirect('tool/'.$next[0]->id.'/edit'); 
        }
    }


    public function savetoolinfo(Request $request)
    {
        $id = $request->id;
        $data = $request->data;
        $fn = $data['fn']; // supplier shortname

        $detail = Detail::where('tool_id', '=', $id)->first();

        if ($detail === null){
            $detail = Detail::saveDetails($id, $data);
        } else {
            // Update Detail
            $detail->tool_id = $id;
            $detail->title1 = $data['title1'];
            $detail->title2 = $data['title2'];
            $detail->cuttingdata = $data['cuttingdata'];
            $detail->description = $data['description'];
            $detail->save();
        }

        if (count($data['images']) > 0) {
            foreach($data['images'] as $url)
            {
                $this->savePicture($id, $data, $url);
            }
        }
        return "Success";
    }


    private function savePicture($id, $data, $url)
    {
        $path = '/pictures/'.$data['fn'].'/'.basename($url);

        $picture = Picture::where('path', '=', $path)->first();
        if($picture === null)
        {
            $content = file_get_contents($url);
            Storage::disk('files')->put($path, $content);

            $picture = Picture::create(array(
                'title' => basename($url),
                'path' => $path
            ));

            DB::table('pictures_tools')->insert([   
                'tool_id' => $id,  
                'picture_id' => $picture->id
            ]);
        } elseif ($picture)
        {
            $pictures_tools = DB::table('pictures_tools')
            ->where('tool_id', $id)
            ->where('picture_id', $picture->id)->first();

            if(!$pictures_tools)
            {
                DB::table('pictures_tools')->insert([   
                    'tool_id' => $id,  
                    'picture_id' => $picture->id
                ]);
            }
        }
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
      $result = '<ul id="category-menu" data-height="505" style="width:100%" class="menu-trigger accordion-menu" data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
      <li id="category-0" class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <span class="title"> Alla Verktøy</span>
        </a></li>';
      foreach ($rows as $row)
      {
        $nav_toggle = '';
        $span = '';
        if ($this->has_children($rows,$row->id)) 
        {
            $nav_toggle = 'nav-toggle';
            $span = '<span class="arrow "></span>';
        }

        if ($row->icon != "") 
        {
            $icon = '<img src="http://tms.local/img/ICO/'.$row->icon.'.png">';
        } else
        {
            $icon = '<i class=" icon-plus"></i>';
        }

        if ($row->parent_id == $parent){
          $result.= '<li id="category-'.$row->id.'" class="nav-item"><a href="javascript:;" class="nav-link '.$nav_toggle.'">'
                    .$icon.'<span class="title"> '.$row->name.'</span>'.$span.'</a>';

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
            $span = '<span class="arrow "></span>';
        }

        if ($row->icon != "") 
        {
            $icon = '<img src="http://tms.local/img/ICO/'.$row->icon.'.png">';
        } else
        {
            $icon = '<i class=" icon-plus"></i>';
        }

        if ($row->parent_id == $parent){
          $result.= '<li id="category-'.$row->id.'" class="nav-item start "><a href="javascript:;" class="nav-link '.$nav_toggle.'">'
                    .$icon.'<span class="title"> '.$row->name.'</span>'.$span.'</a>';

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
