<?php

namespace App\Http\Controllers;

use DB;
use URL;
use HtmlDom;
use Storage;
use Searchy;
use App\Models\Cost;
use App\Models\File;
use App\Models\Detail;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Inventory;
use App\Services\AjaxTable;
use Illuminate\Http\Request;
use App\Models\InventoryStock;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\Tool\SearchToolRequest;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;


class InventoryController extends Controller {

    protected $orders;


    public function __construct()
    {
    }


    public function index()
    {
        $categories = Category::all()->toHierarchy();
        $accordion = $this->build_menu($categories);

        return view('inventory.index', compact('accordion'));
    }

    /**
     * View a specific Inventory
     *
     * @param Inventory        $item
     *
     * @return view
     */
    public function view(Inventory $item)
    {
        return view('inventory.view', compact('item'));
    }

    /**
     * Generate Sku
     *
     * @param Inventory        $item
     *
     * @return json
     */
    public function generateSku(Inventory $item)
    {
        return $item->generateSku();;
    }

    /**
     * Request a specific Inventory from View Page
     *
     * @param Request          $request (Ajax)
     * @param Inventory        $item
     *
     * @return array
     */
    public function request(Request $request, Inventory $item)
    {
        /**
         * If stock don't exist for this item, create it in location 1 (Nonlocated)
         * with zero quantity.
         * If stock exist, fetch the stock from record.
         */
        if (count($item->stocks) == 0) {
            $stock = $item->newStockOnLocation(Location::find(1));
            $stock->quantity = 0;
            $stock->save();
        } else {
            $stock = InventoryStock::where('inventory_id', $item->id)->first();
        }

        // Create new Request Transaction (order-requested)
        $transaction = $stock->newTransaction('Request Transaction');
        $transaction->requested(10);

        return $transaction;
    }

    /**
     * Fetch all tools from database
     *
     * @param Request          $request (Ajax)
     *
     * @return array
     */
    public function db(Request $request)
    {
        if ($request->ajax())
        {
            $tools = new AjaxTable($request);
            $tools->select('inventories', array('id', 'serialnr'));
            $tools->with('categories', array('id', 'name'), 'id', 'inventories', 'category_id');
            $tools->with('inventory_suppliers', array('supplier_id'), 'inventory_id', 'inventories', 'id');
            $tools->with('suppliers', array('name'), 'id', 'inventory_suppliers', 'supplier_id');

            return $tools->get();
        }
        else
        {}

    }

    /**
     * Returns all serialnumbers found from Ajax call
     *
     * @param Request          $request (Ajax)
     *
     * @return json array
     */
    public function instantSearchSerialnr(Request $request)
    {
        $results = array();

        $items = Inventory::fuzzySearch('inventories', 'serialnr', $request->input('query'));

        foreach($items as $item) {
            $results[] =  $item->serialnr;
        }

        return json_encode($results);
    }

    /**
     * Returns one item from Inventory matching the barcode
     * that was requested from Ajax call
     *
     * @param Request          $request (Ajax)
     *
     * @return json array
     */
    public function instantSearchBarcode(Request $request)
    {
        $barcode = $request->input('query');

        if($barcode[0] == "(") {
            $barcode = rtrim($request->input('query'), ")");
            $barcode = trim($barcode, "(");
        }
        $result = Inventory::findByBarcode($barcode);

        return json_encode($result);
    }

    /**
     * Returns one item from Inventory matching the serialnr
     * that was requested from Ajax call
     *
     * @param Request          $request (Ajax)
     *
     * @return json array
     */
    public function getInventoryBySerialnr(Request $request)
    {
        $serialnr = $request->input('query');

        $result = Inventory::findBySerialnr($serialnr);

        return json_encode($result);
    }


    public function search()
    {
        return view('tool.search');
    }


    public function result(Request $request)
    {
        $this->validate($request, [
            'term' => 'required',
        ]);

        $term = $request->term;
        $currentPage = $request->get('page', 1);

        $max = 12;
        $from = $currentPage * $max - $max;
        $to = $max;

        $query = Tool::fuzzySearch('tools', 'serialnr', $term); //Searchy::driver('fuzzy')->tools('serialn')->query($term)->get();

        $collection = collect($query);
        $total = count($query);

        $result = $collection->splice($from, $to);

        $pictures = array();
        foreach($result as $tool)
        {
            $pictures[] = Tool::find($tool->id)->PreferredToolPicture();
        }

        $paginator = new LengthAwarePaginator($result, $total, $max, $currentPage);
        $paginator->setPath('result');

        return view('tool.search', compact('result', 'term', 'currentPage', 'total', 'max', 'paginator', 'pictures'));
    }


    /**
     * Goto New Inventory page
     * GET /inventory/new
     *
     * @return View
     */
    public function new()
    {
        $suppliers = Supplier::all();

        return view('inventory.new', compact('suppliers'));
    }

    /**
     * Create New Inventory
     * POST /inventory/create
     *
     * @param Request          $request
     *
     * @return redirect
     */
    public function create(Request $request)
    {
        $item = New Inventory;

        $item->metric_id = 1;   // Stk
        $item->name = $request->name;
        $item->name0 = $request->name0;
        $item->serialnr = $request->serialnr;

        // Find the last category in array which is not zero
        $i = 0;
        $length = count($request->category) - 1;
        while($request->category[$i] != 0 && $i < $length)
        {
            $i++;
            $category_id = $request->category[$i];
        }

        // If category was posted add it to inventory.
        // If not, add it to Root Category with id 1
        if(isset($category_id)){
            $item->category_id = $category_id;
        } else {
            $item->category_id = 1;
        }

        $item->save();

        return redirect('inventory/new');
    }

    /**
     * Goto Edit Inventory page
     * GET /inventory/(id)/edit
     *
     * @return View
     */
    public function edit(Inventory $item)
    {
        $suppliers = Supplier::all();

        // Create Navigation for Next and Previous Tool
        $navigate = $item->getNextPrev();

        return view('inventory.edit', compact('item', 'suppliers', 'navigate'));
    }

    /**
     * Update inventory item
     * GET /inventory/(item)/save
     *
     * @param Request          $request
     * @param Inventory        $item
     *
     * @return
     */
    public function save(Request $request, Inventory $item)
    {
        $offset = count($request->category) - 1;

        /*
         * Set Category to NULL if requested category is 0
         */
        $category = $request->category[$offset];
        if ($category == 0 && $offset < 1) {
            $category = NULL;
        } elseif ($category == 0) {
            $category = $request->category[$offset - 1];
        }

        $item->serialnr = $request->serialnr;
        $item->name = $request->name;
        $item->name0 = $request->name0;
        $item->category_id = $category;
        $item->save();

        //$item->updateBarcode($request->barcode);

        return $item;
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
            $icon = '<img src="'.URL::to('img/ICO/').'/'.$row->icon.'.png">';
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
            $icon = '<img src="'.URL::to('img/ICO/').'/'.$row->icon.'.png">';
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
