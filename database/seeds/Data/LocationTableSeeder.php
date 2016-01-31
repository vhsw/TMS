<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Location;

class LocationTableSeeder extends Seeder {

	public function run() {

        DB::table('locations')->delete();

        Location::create(['name'=>'Bor','location'=>'01-01-01']);
        Location::create(['name'=>'Bor','location'=>'01-01-02']);
        Location::create(['name'=>'Bor','location'=>'01-01-03']);
        Location::create(['name'=>'Bor','location'=>'01-01-04']);
        Location::create(['name'=>'Bor','location'=>'01-01-05']);
	        
	}
}
