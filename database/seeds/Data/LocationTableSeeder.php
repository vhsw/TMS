<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Location;

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

	}
}
