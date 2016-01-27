<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Tool;

class ToolsTableSeeder extends Seeder {
    public function run(){

        \DB::table('tools')->delete();
        $contents = \Storage::disk('database')->get('tools2.json');
        //$tools = json_decode($contents);

        $jsonIterator = json_decode($contents, TRUE);

        foreach ($jsonIterator as $key => $val)
        {
            echo $val['serialnr']; //Tool::create(['serialnr'=>$tool->serialnr, 'name0'=>$tool->name0, 'category_id' =>1, 'supplier_id' =>$tool->supplier_id]);
        }
	}
}