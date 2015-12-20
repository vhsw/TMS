<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Tool;

class ToolsTableSeeder extends Seeder {
    public function run(){

        DB::table('tools')->delete();
        $contents = Storage::disk('database')->get('tools.json');
        $tools = json_decode($contents);

        foreach ($tools as $tool)
        {
            Tool::create(['serialnr'=>$tool->serialnr, 'name0'=>$tool->name1, 'barcode'=>$tool->barcode, 'category_id' =>$tool->category_id, 'brand_id' =>$tool->brand_id]);
        }
}}