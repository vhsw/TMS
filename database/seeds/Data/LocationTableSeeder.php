<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Location;
use App\Models\Metric;

class LocationTableSeeder extends Seeder {

	public function run() {

        DB::table('locations')->delete();

		//Create Location
        $location = new Location;
        $location->name = 'Nonlocated';
        $location->save();

		$location = new Location;
        $location->name = 'Tools';
        $location->save();


		DB::table('metrics')->delete();

		$metric = new Metric;
		$metric->name = "Stk";
		$metric->symbol = "stk";
		$metric->save();
	}
}
