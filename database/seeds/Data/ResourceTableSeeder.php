<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Resource;

class ResourceTableSeeder extends Seeder {

	public function run() {

        DB::table('resources')->delete();

        Resource::create(['name'=>'Doosan Puma 700LM', 'short_name'=>'Puma 700LM', 'controller'=>'Fanuc 2liT']);
        Resource::create(['name'=>'Mazak Quick-Turn Nexus 250-II M', 'short_name'=>'Nexus 250','controller'=>'Mazatrol Matrix']);
        Resource::create(['name'=>'Mazak Horizontal Center Nexus 6800-II', 'short_name'=>'Nexus 6800-II','controller'=>'Mazatrol Matrix']);
        Resource::create(['name'=>'Mazak Quick-Turn Nexus 350MY x 1500', 'short_name'=>'Nexus 350MY','controller'=>'Mazatrol 640T']);
        Resource::create(['name'=>'Mazak Integrex 200Y', 'short_name'=>'Integrex 200Y','controller'=>'Mazatrol 640MT']);
        Resource::create(['name'=>'Mazak Integrex 35Y x 1500', 'short_name'=>'Integrex 35Y','controller'=>'Mazatrol T+']);
        Resource::create(['name'=>'Mazak Quick Turn 20', 'short_name'=>'Quick Turn 20','controller'=>'Mazatrol T+']);
	        
	}
}
